<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminExpenseController extends Controller
{
    public function index(Request $request)
    {
        $monthFilter = trim((string) $request->query('month', ''));
        $categoryFilter = trim((string) $request->query('category', ''));

        $query = Expense::query()->orderByDesc('expense_date')->orderByDesc('id');

        if ($monthFilter !== '' && preg_match('/^\d{4}-\d{2}$/', $monthFilter)) {
            [$year, $month] = explode('-', $monthFilter);
            $query->whereYear('expense_date', (int) $year)
                  ->whereMonth('expense_date', (int) $month);
        } else {
            $monthFilter = '';
        }

        if ($categoryFilter !== '' && array_key_exists($categoryFilter, Expense::CATEGORIES)) {
            $query->where('category', $categoryFilter);
        } else {
            $categoryFilter = '';
        }

        $expenses = $query->get();

        $today = Carbon::today();
        $todayTotal = (int) Expense::whereDate('expense_date', $today)->sum('amount');
        $monthTotal = (int) Expense::whereYear('expense_date', $today->year)
            ->whereMonth('expense_date', $today->month)
            ->sum('amount');
        $adsTotal = (int) Expense::where('category', 'iklan')->sum('amount');
        $allTimeTotal = (int) Expense::sum('amount');

        $filteredTotal = (int) $expenses->sum('amount');

        // Rekap per bulan (12 bulan terakhir yang memiliki data)
        $monthlyRecap = Expense::query()
            ->selectRaw("DATE_FORMAT(expense_date, '%Y-%m') as ym, COUNT(*) as total_items, SUM(amount) as total_amount")
            ->groupBy('ym')
            ->orderByDesc('ym')
            ->limit(12)
            ->get()
            ->map(function ($row) {
                $dt = Carbon::createFromFormat('Y-m', $row->ym);
                $row->label = $dt ? $dt->translatedFormat('F Y') : $row->ym;
                return $row;
            });

        return view('admin.expenses', [
            'expenses' => $expenses,
            'categories' => Expense::CATEGORIES,
            'monthFilter' => $monthFilter,
            'categoryFilter' => $categoryFilter,
            'todayTotal' => $todayTotal,
            'monthTotal' => $monthTotal,
            'adsTotal' => $adsTotal,
            'allTimeTotal' => $allTimeTotal,
            'filteredTotal' => $filteredTotal,
            'monthlyRecap' => $monthlyRecap,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateExpense($request);

        Expense::create([
            ...$validated,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.expenses.index')
            ->with('success', 'Pengeluaran berhasil dicatat.');
    }

    public function update(Request $request, int $id)
    {
        $expense = Expense::findOrFail($id);
        $validated = $this->validateExpense($request);

        $expense->update($validated);

        return back()->with('success', 'Data pengeluaran berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();

        return back()->with('success', 'Data pengeluaran berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateExpense(Request $request): array
    {
        $cleanAmount = preg_replace('/\D+/', '', (string) $request->input('amount', ''));
        $request->merge(['amount' => $cleanAmount === '' ? null : (int) $cleanAmount]);

        return $request->validate([
            'expense_date' => ['required', 'date'],
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:' . implode(',', array_keys(Expense::CATEGORIES))],
            'amount' => ['required', 'integer', 'min:1'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ], [
            'expense_date.required' => 'Tanggal pengeluaran wajib diisi.',
            'name.required' => 'Nama pengeluaran wajib diisi.',
            'category.required' => 'Pilih kategori pengeluaran.',
            'amount.required' => 'Nominal pengeluaran wajib diisi.',
            'amount.min' => 'Nominal pengeluaran minimal Rp 1.',
        ]);
    }
}
