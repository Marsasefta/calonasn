<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Tryout;
use Illuminate\Database\Seeder;

class ExamBankSeeder extends Seeder
{
    /**
     * Seed the application's exam bank.
     */
    public function run(): void
    {
        $tryout = Tryout::firstOrCreate([
            'title' => 'Tryout CPNS CalonASN',
        ], [
            'description' => 'Tryout sample untuk TWK, TIU, dan TKP.',
            'schedule_at' => now()->addDays(7),
            'duration_minutes' => 100,
            'price' => 20000,
            'is_active' => true,
            'status' => 'active',
        ]);

        $examBank = [
            'TWK' => [
                [
                    'question_text' => 'Sila keempat Pancasila berbunyi: “Kerakyatan yang dipimpin oleh hikmat kebijaksanaan dalam permusyawaratan/perwakilan.” Prinsip ini menekankan pentingnya . . .',
                    'options' => [
                        'a' => 'demokrasi langsung',
                        'b' => 'kebijaksanaan dalam musyawarah',
                        'c' => 'pembagian kekuasaan',
                        'd' => 'hak asasi manusia',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Undang-Undang Dasar 1945 mengamanatkan bahwa kedaulatan berada di tangan . . .',
                    'options' => [
                        'a' => 'Presiden',
                        'b' => 'DPR',
                        'c' => 'MPR',
                        'd' => 'rakyat',
                    ],
                    'correct' => 'd',
                ],
                [
                    'question_text' => 'Lambang negara Garuda Pancasila memiliki semboyan “Bhinneka Tunggal Ika.” Makna yang paling tepat dari semboyan tersebut adalah . . .',
                    'options' => [
                        'a' => 'Persatuan dalam perbedaan',
                        'b' => 'Kemajemukan yang terpisah',
                        'c' => 'Keadilan sosial bagi seluruh bangsa',
                        'd' => 'Ketuhanan yang maha esa',
                    ],
                    'correct' => 'a',
                ],
                [
                    'question_text' => 'Ikrar Sumpah Pemuda tahun 1928 menyatakan bahwa bangsa Indonesia adalah . . .',
                    'options' => [
                        'a' => 'bangsa Melayu',
                        'b' => 'bangsa Indonesia',
                        'c' => 'bangsa Nusantara',
                        'd' => 'bangsa Asia Tenggara',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Demokrasi Pancasila berbeda dengan demokrasi liberterian karena menempatkan . . .',
                    'options' => [
                        'a' => 'kebebasan individu di atas segalanya',
                        'b' => 'kepentingan umat beragama',
                        'c' => 'kolektivitas dan musyawarah',
                        'd' => 'otoritas pemerintah yang kuat',
                    ],
                    'correct' => 'c',
                ],
                [
                    'question_text' => 'Secara konstitusional, Presiden Indonesia dipilih oleh . . .',
                    'options' => [
                        'a' => 'DPR',
                        'b' => 'MPR',
                        'c' => 'susunan partai politik',
                        'd' => 'rakyat secara langsung',
                    ],
                    'correct' => 'd',
                ],
                [
                    'question_text' => 'Hakekat negara hukum menurut UUD 1945 adalah . . .',
                    'options' => [
                        'a' => 'memihak kepada pejabat',
                        'b' => 'mematuhi semua peraturan tanpa kecuali',
                        'c' => 'menegakkan hukum secara adil bagi semua',
                        'd' => 'mengutamakan keamanan nasional',
                    ],
                    'correct' => 'c',
                ],
                [
                    'question_text' => 'Menurut sistem ketatanegaraan Indonesia, kekuasaan kehakiman berada di bawah . . .',
                    'options' => [
                        'a' => 'Presiden',
                        'b' => 'DPR',
                        'c' => 'Mahkamah Agung',
                        'd' => 'KPK',
                    ],
                    'correct' => 'c',
                ],
                [
                    'question_text' => 'Indonesia memiliki semboyan Bhinneka Tunggal Ika. Hal ini mengandung arti pentingnya . . .',
                    'options' => [
                        'a' => 'kesamaan budaya',
                        'b' => 'persatuan dalam keanekaragaman',
                        'c' => 'dominasi satu kelompok',
                        'd' => 'persaingan antar daerah',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Salah satu tujuan negara Indonesia menurut Pembukaan UUD 1945 adalah . . .',
                    'options' => [
                        'a' => 'meningkatkan produksi industri',
                        'b' => 'melindungi segenap bangsa Indonesia',
                        'c' => 'mencapai kesejahteraan global',
                        'd' => 'menguasai wilayah Asia Tenggara',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Sistem pemerintahan Indonesia saat ini adalah . . .',
                    'options' => [
                        'a' => 'presidensial',
                        'b' => 'parlementer',
                        'c' => 'monarki konstitusional',
                        'd' => 'pemerintahan militer',
                    ],
                    'correct' => 'a',
                ],
                [
                    'question_text' => 'Lembaga eksekutif di Indonesia pada tingkat nasional dijalankan oleh . . .',
                    'options' => [
                        'a' => 'MPR',
                        'b' => 'Presiden dan Wakil Presiden',
                        'c' => 'DPR',
                        'd' => 'MA',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Dalam konteks wawasan nusantara, Indonesia dipandang sebagai . . .',
                    'options' => [
                        'a' => 'kawasan pertanian',
                        'b' => 'negara maritim',
                        'c' => 'negara industri',
                        'd' => 'negara padat penduduk',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Prinsip nasionalisme yang digunakan oleh bangsa Indonesia adalah . . .',
                    'options' => [
                        'a' => 'nasionalisme etnis',
                        'b' => 'nasionalisme budaya asing',
                        'c' => 'nasionalisme kebangsaan',
                        'd' => 'nasionalisme ekonomi',
                    ],
                    'correct' => 'c',
                ],
                [
                    'question_text' => 'Salah satu tugas Mahkamah Konstitusi adalah . . .',
                    'options' => [
                        'a' => 'mengadili perkara perdata biasa',
                        'b' => 'menetapkan pendapat DPR',
                        'c' => 'mengadili sengketa hasil pemilihan umum',
                        'd' => 'mengeluarkan peraturan presiden',
                    ],
                    'correct' => 'c',
                ],
                [
                    'question_text' => 'Sistem politik Indonesia berdasarkan UUD 1945 menempatkan kekuasaan tertinggi pada . . .',
                    'options' => [
                        'a' => 'Presiden',
                        'b' => 'DPR',
                        'c' => 'rakyat',
                        'd' => 'Mahkamah Agung',
                    ],
                    'correct' => 'c',
                ],
                [
                    'question_text' => 'Wajib belajar 12 tahun di Indonesia diatur untuk menjamin . . .',
                    'options' => [
                        'a' => 'akses pendidikan bagi seluruh rakyat',
                        'b' => 'pelatihan tenaga kerja asing',
                        'c' => 'pemberian beasiswa luar negeri',
                        'd' => 'pembatasan sekolah swasta',
                    ],
                    'correct' => 'a',
                ],
                [
                    'question_text' => 'Makna persatuan bangsa menurut Pancasila adalah . . .',
                    'options' => [
                        'a' => 'menjadikan satu budaya utama',
                        'b' => 'menghilangkan adat istiadat',
                        'c' => 'menjaga keragaman dan persatuan',
                        'd' => 'memaksakan satu bahasa resmi',
                    ],
                    'correct' => 'c',
                ],
                [
                    'question_text' => 'Dalam tiga daerah otonomi khusus, salah satunya adalah . . .',
                    'options' => [
                        'a' => 'Jawa Barat',
                        'b' => 'Aceh',
                        'c' => 'Bali',
                        'd' => 'Jawa Timur',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Sistem desentralisasi di Indonesia bertujuan untuk . . .',
                    'options' => [
                        'a' => 'memusatkan kekuasaan',
                        'b' => 'memberi ruang bagi daerah mengatur urusannya sendiri',
                        'c' => 'meninggalkan daerah tanpa pengawasan',
                        'd' => 'mengurangi wewenang kepala daerah',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Hubungan antara negara dan agama di Indonesia diatur dengan prinsip . . .',
                    'options' => [
                        'a' => 'sekuler total',
                        'b' => 'negara agama',
                        'c' => 'sekuler terbatas',
                        'd' => 'negara berketuhanan',
                    ],
                    'correct' => 'd',
                ],
                [
                    'question_text' => 'Peran pemerintah dalam pembangunan nasional adalah . . .',
                    'options' => [
                        'a' => 'menjadi satu-satunya pelaksana',
                        'b' => 'memfasilitasi dan mengarahkan pembangunan',
                        'c' => 'menghilangkan swasta dari pembangunan',
                        'd' => 'mengurangi investasi asing',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Kebijakan luar negeri Indonesia berdasarkan politik bebas aktif artinya . . .',
                    'options' => [
                        'a' => 'berpihak pada satu blok kekuatan',
                        'b' => 'bebas dari pengaruh asing dan aktif dalam perdamaian dunia',
                        'c' => 'mengabaikan hubungan internasional',
                        'd' => 'menjadi anggota sekutu militer',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Peran partisipasi masyarakat dalam demokrasi Pancasila adalah . . .',
                    'options' => [
                        'a' => 'menunggu arahan pemerintah',
                        'b' => 'mengutamakan kepentingan pribadi',
                        'c' => 'mengikuti musyawarah untuk mencapai mufakat',
                        'd' => 'menghindari kegiatan politik',
                    ],
                    'correct' => 'c',
                ],
                [
                    'question_text' => 'Salah satu fungsi dasar negara menurut ilmu politik adalah . . .',
                    'options' => [
                        'a' => 'mengontrol cuaca',
                        'b' => 'melindungi dan membimbing warga negara',
                        'c' => 'menghasilkan keuntungan ekonomi sendiri',
                        'd' => 'mengeksploitasi negara lain',
                    ],
                    'correct' => 'b',
                ],
            ],
            'TIU' => [
                [
                    'question_text' => 'Jika 3x + 5 = 20, maka nilai x adalah . . .',
                    'options' => [
                        'a' => '5',
                        'b' => '6',
                        'c' => '4',
                        'd' => '3',
                    ],
                    'correct' => 'a',
                ],
                [
                    'question_text' => 'Seorang pedagang membeli 10 barang seharga Rp 2.500 masing-masing, lalu menjualnya 20% lebih mahal. Total keuntungan pedagang tersebut adalah . . .',
                    'options' => [
                        'a' => 'Rp 5.000',
                        'b' => 'Rp 4.000',
                        'c' => 'Rp 6.000',
                        'd' => 'Rp 3.000',
                    ],
                    'correct' => 'a',
                ],
                [
                    'question_text' => 'Jika lima buku seharga Rp 150.000, maka harga satu buku adalah . . .',
                    'options' => [
                        'a' => 'Rp 25.000',
                        'b' => 'Rp 30.000',
                        'c' => 'Rp 35.000',
                        'd' => 'Rp 40.000',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Deret bilangan: 2, 5, 10, 17, 26, ... selanjutnya adalah . . .',
                    'options' => [
                        'a' => '35',
                        'b' => '36',
                        'c' => '37',
                        'd' => '38',
                    ],
                    'correct' => 'c',
                ],
                [
                    'question_text' => 'Jika 7 + x = 2x - 5, maka x = . . .',
                    'options' => [
                        'a' => '12',
                        'b' => '7',
                        'c' => '5',
                        'd' => '2',
                    ],
                    'correct' => 'a',
                ],
                [
                    'question_text' => 'Sebuah proyek selesai dalam 6 hari oleh 8 pekerja. Jika hanya 6 pekerja, waktu yang diperlukan adalah . . .',
                    'options' => [
                        'a' => '8 hari',
                        'b' => '9 hari',
                        'c' => '10 hari',
                        'd' => '12 hari',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Jika p : q = 3 : 4 dan p + q = 28, maka nilai p adalah . . .',
                    'options' => [
                        'a' => '12',
                        'b' => '8',
                        'c' => '15',
                        'd' => '10',
                    ],
                    'correct' => 'a',
                ],
                [
                    'question_text' => 'Tiga kota A, B, C saling terpisah. Jarak A ke B 120 km, B ke C 80 km. Jarak terpendek A ke C melalui B adalah . . .',
                    'options' => [
                        'a' => '200 km',
                        'b' => '80 km',
                        'c' => '120 km',
                        'd' => '40 km',
                    ],
                    'correct' => 'a',
                ],
                [
                    'question_text' => 'Jika sebuah segitiga siku-siku memiliki sisi siku-siku 6 cm dan 8 cm, panjang hipotenusanya adalah . . .',
                    'options' => [
                        'a' => '10 cm',
                        'b' => '12 cm',
                        'c' => '14 cm',
                        'd' => '8 cm',
                    ],
                    'correct' => 'a',
                ],
                [
                    'question_text' => 'Perbandingan berat antara 4 kg dan 12 kg dapat dinyatakan sebagai . . .',
                    'options' => [
                        'a' => '4 : 12',
                        'b' => '1 : 3',
                        'c' => '3 : 1',
                        'd' => '2 : 6',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Jika 30% dari suatu jumlah adalah 60, maka jumlah tersebut adalah . . .',
                    'options' => [
                        'a' => '150',
                        'b' => '180',
                        'c' => '200',
                        'd' => '210',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Logika: Semua manusia adalah makhluk hidup. Semua dokter adalah manusia. Kesimpulan yang benar adalah . . .',
                    'options' => [
                        'a' => 'Semua dokter bukan makhluk hidup',
                        'b' => 'Beberapa dokter bukan manusia',
                        'c' => 'Semua dokter adalah makhluk hidup',
                        'd' => 'Semua makhluk hidup adalah dokter',
                    ],
                    'correct' => 'c',
                ],
                [
                    'question_text' => 'Sebuah toko memberikan diskon 15% untuk barang seharga Rp 200.000. Harga setelah diskon adalah . . .',
                    'options' => [
                        'a' => 'Rp 170.000',
                        'b' => 'Rp 175.000',
                        'c' => 'Rp 180.000',
                        'd' => 'Rp 185.000',
                    ],
                    'correct' => 'c',
                ],
                [
                    'question_text' => 'Jika nilai x adalah 4 dan nilai y adalah 3, maka nilai x^2 + y^2 adalah . . .',
                    'options' => [
                        'a' => '25',
                        'b' => '20',
                        'c' => '16',
                        'd' => '7',
                    ],
                    'correct' => 'a',
                ],
                [
                    'question_text' => 'Seorang penjual membeli 40 buku dengan harga Rp 8.000 per buku, lalu menjualnya 25% lebih mahal. Keuntungan totalnya adalah . . .',
                    'options' => [
                        'a' => 'Rp 20.000',
                        'b' => 'Rp 80.000',
                        'c' => 'Rp 40.000',
                        'd' => 'Rp 50.000',
                    ],
                    'correct' => 'c',
                ],
                [
                    'question_text' => 'Rata-rata dari 8, 12, 15, x adalah 12. Nilai x adalah . . .',
                    'options' => [
                        'a' => '11',
                        'b' => '12',
                        'c' => '13',
                        'd' => '14',
                    ],
                    'correct' => 'd',
                ],
                [
                    'question_text' => 'Jika 2 jam 45 menit lebih cepat 1 jam 20 menit dibandingkan waktu X, maka X sama dengan . . .',
                    'options' => [
                        'a' => '4 jam 5 menit',
                        'b' => '5 jam',
                        'c' => '4 jam 15 menit',
                        'd' => '3 jam 25 menit',
                    ],
                    'correct' => 'a',
                ],
                [
                    'question_text' => 'Bilangan prima terkecil kelima adalah . . .',
                    'options' => [
                        'a' => '11',
                        'b' => '13',
                        'c' => '7',
                        'd' => '17',
                    ],
                    'correct' => 'a',
                ],
                [
                    'question_text' => 'Jika hitungan 4x - 6 = 2(x + 3), maka x = . . .',
                    'options' => [
                        'a' => '6',
                        'b' => '3',
                        'c' => '2',
                        'd' => '9',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Kata yang paling tepat menggantikan kata “intensif” dalam kalimat “Pelatihan ini bersifat intensif” adalah . . .',
                    'options' => [
                        'a' => 'jarang',
                        'b' => 'ringan',
                        'c' => 'terus-menerus',
                        'd' => 'cepat',
                    ],
                    'correct' => 'c',
                ],
                [
                    'question_text' => 'Sinonim kata “profesional” yang paling tepat adalah . . .',
                    'options' => [
                        'a' => 'cerdas',
                        'b' => 'berpengalaman',
                        'c' => 'ternyata',
                        'd' => 'berambisi',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Antonim kata “optimis” adalah . . .',
                    'options' => [
                        'a' => 'realistis',
                        'b' => 'pesimis',
                        'c' => 'ekstrim',
                        'd' => 'sabar',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Kalimat efektif yang benar adalah . . .',
                    'options' => [
                        'a' => 'Pemimpin itu telah memimpin dengan baik.',
                        'b' => 'Pemimpin itu memimpin dengan baik selalu.',
                        'c' => 'Telah memimpin pemimpin itu dengan baik.',
                        'd' => 'Pemimpin tersebut memimpin dengan baik.',
                    ],
                    'correct' => 'd',
                ],
                [
                    'question_text' => 'Jika semua karyawan mengikuti pelatihan, maka produktivitas meningkat. Semua karyawan mengikuti pelatihan. Kesimpulan yang tepat adalah . . .',
                    'options' => [
                        'a' => 'Produktivitas tidak berubah',
                        'b' => 'Produktivitas meningkat',
                        'c' => 'Hanya beberapa produktivitas meningkat',
                        'd' => 'Pelatihan gagal',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Sinonim kata “adaptasi” adalah . . .',
                    'options' => [
                        'a' => 'penyesuaian',
                        'b' => 'pengabaian',
                        'c' => 'pertentangan',
                        'd' => 'pengingkaran',
                    ],
                    'correct' => 'a',
                ],
                [
                    'question_text' => 'Kalimat berikut yang menggunakan tanda baca koma dengan tepat adalah . . .',
                    'options' => [
                        'a' => 'Kami membeli buah, dan sayur.',
                        'b' => 'Dia, menulis laporan tugasnya.',
                        'c' => 'Budi membawa buku, pensil, dan penghapus.',
                        'd' => 'Besok pergi, ke kantor.',
                    ],
                    'correct' => 'c',
                ],
                [
                    'question_text' => 'Dalam penelitian, hipotesis merupakan . . .',
                    'options' => [
                        'a' => 'kesimpulan akhir',
                        'b' => 'pertanyaan riset',
                        'c' => 'prediksi sementara',
                        'd' => 'metode penelitian',
                    ],
                    'correct' => 'c',
                ],
                [
                    'question_text' => 'Sistem bilangan biner 1010 jika dikonversi ke desimal menjadi . . .',
                    'options' => [
                        'a' => '10',
                        'b' => '12',
                        'c' => '8',
                        'd' => '14',
                    ],
                    'correct' => 'a',
                ],
                [
                    'question_text' => 'Jika sebuah nilai x membuat persamaan 2x + 7 = 19, maka x adalah . . .',
                    'options' => [
                        'a' => '6',
                        'b' => '5',
                        'c' => '7',
                        'd' => '4',
                    ],
                    'correct' => 'a',
                ],
                [
                    'question_text' => 'Angka yang hilang pada deret 4, 9, 16, 25, _, 49 adalah . . .',
                    'options' => [
                        'a' => '32',
                        'b' => '36',
                        'c' => '34',
                        'd' => '40',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Suppose the word “loud” means “small” and “slowly” means “quickly”. In that language, the sentence “She speaks loudly” means . . .',
                    'options' => [
                        'a' => 'She speaks small',
                        'b' => 'She speaks quickly',
                        'c' => 'She speaks quietly',
                        'd' => 'She speaks slowly',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'The antonym of “complicated” is . . .',
                    'options' => [
                        'a' => 'difficult',
                        'b' => 'detailed',
                        'c' => 'simple',
                        'd' => 'complex',
                    ],
                    'correct' => 'c',
                ],
                [
                    'question_text' => 'What is the best word to complete the sentence: “The manager made a ______ decision.”',
                    'options' => [
                        'a' => 'rash',
                        'b' => 'careful',
                        'c' => 'hasty',
                        'd' => 'uncertain',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Choose the opposite of “flexible”.',
                    'options' => [
                        'a' => 'rigid',
                        'b' => 'mobile',
                        'c' => 'adaptable',
                        'd' => 'pliable',
                    ],
                    'correct' => 'a',
                ],
                [
                    'question_text' => 'If every engineer is a problem solver, and some problem solvers are managers, which statement is true?',
                    'options' => [
                        'a' => 'All managers are engineers',
                        'b' => 'Some managers are engineers',
                        'c' => 'No managers are engineers',
                        'd' => 'All problem solvers are engineers',
                    ],
                    'correct' => 'b',
                ],
            ],
            'TKP' => [
                [
                    'question_text' => 'Seorang rekan kerja meminta bantuan menyelesaikan tugas di luar jam kerja. Sikap yang paling tepat adalah . . .',
                    'options' => [
                        'a' => 'menolak karena terlalu sibuk',
                        'b' => 'membantu jika masih memungkinkan',
                        'c' => 'meninggalkan tugas tersebut',
                        'd' => 'meminta orang lain yang tidak sibuk',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Jika Anda melihat seorang siswa menyontek saat ujian, tindakan yang paling profesional adalah . . .',
                    'options' => [
                        'a' => 'mengabaikannya',
                        'b' => 'mengomeli siswa tersebut',
                        'c' => 'melaporkan pada pengawas ujian',
                        'd' => 'menyontek bersama',
                    ],
                    'correct' => 'c',
                ],
                [
                    'question_text' => 'Dalam bekerja, loyalitas kepada lembaga berarti . . .',
                    'options' => [
                        'a' => 'mendahulukan kepentingan pribadi',
                        'b' => 'mengikuti aturan dan mendukung tujuan organisasi',
                        'c' => 'membangkang terhadap kebijakan',
                        'd' => 'berhenti ketika tidak disukai',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Sikap yang menunjukkan integritas adalah . . .',
                    'options' => [
                        'a' => 'menyembunyikan kesalahan',
                        'b' => 'mengakui kesalahan dan memperbaikinya',
                        'c' => 'menyalahkan orang lain',
                        'd' => 'mengulangi kesalahan yang sama',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Ketika menghadapi masalah rumit dalam pekerjaan, hal terbaik adalah . . .',
                    'options' => [
                        'a' => 'menghindari masalah',
                        'b' => 'mengambil keputusan tanpa informasi',
                        'c' => 'mencari data dan berdiskusi dengan tim',
                        'd' => 'menunggu orang lain menyelesaikannya',
                    ],
                    'correct' => 'c',
                ],
                [
                    'question_text' => 'Seorang pegawai publik harus menjaga rahasia negara. Tindakan yang paling tepat jika mendapat tawaran suap adalah . . .',
                    'options' => [
                        'a' => 'menerima jika besar tawarannya',
                        'b' => 'menolak dan melaporkannya',
                        'c' => 'menyimpan untuk sesama pegawai',
                        'd' => 'membicarakan dengan teman',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Sikap toleransi dalam masyarakat heterogen berarti . . .',
                    'options' => [
                        'a' => 'memaksakan pendapat sendiri',
                        'b' => 'menghargai perbedaan dan bekerja sama',
                        'c' => 'mengisolasi kelompok lain',
                        'd' => 'menolak keragaman budaya',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Kalau Anda melihat lingkungan kantor kotor, hal terbaik yang bisa dilakukan adalah . . .',
                    'options' => [
                        'a' => 'mengabaikannya karena bukan tugas Anda',
                        'b' => 'mengeluh saja',
                        'c' => 'membersihkannya dan mengajak rekan bekerja sama',
                        'd' => 'menunggu petugas kebersihan datang',
                    ],
                    'correct' => 'c',
                ],
                [
                    'question_text' => 'Jika atasan Anda meminta tugas yang menyalahi aturan, tindakan paling tepat adalah . . .',
                    'options' => [
                        'a' => 'melaksanakan saja',
                        'b' => 'menolak dan menjelaskan alasan bahwa hal itu tidak etis',
                        'c' => 'melapor kepada media',
                        'd' => 'mengalihkan tugas kepada rekan',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Sikap profesional terhadap waktu kerja adalah . . .',
                    'options' => [
                        'a' => 'datang terlambat kalau sedang sibuk',
                        'b' => 'menghargai jadwal dan datang tepat waktu',
                        'c' => 'mengerjakan sendiri semua tugas',
                        'd' => 'menunda pekerjaan sampai deadline',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Seorang pegawai yang disiplin biasanya memiliki ciri . . .',
                    'options' => [
                        'a' => 'sering absen',
                        'b' => 'menyelesaikan tugas tepat waktu',
                        'c' => 'melakukan pekerjaan tergesa-gesa',
                        'd' => 'bergantung pada orang lain',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Integritas dalam pelayanan publik berarti . . .',
                    'options' => [
                        'a' => 'mengutamakan keuntungan pribadi',
                        'b' => 'melaksanakan tugas dengan jujur dan adil',
                        'c' => 'mengabaikan aturan jika menguntungkan',
                        'd' => 'menunda pelayanan kepada warga',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Penyesuaian sikap kerja yang baik terhadap perubahan adalah . . .',
                    'options' => [
                        'a' => 'menolak segala perubahan',
                        'b' => 'bersikap fleksibel dan siap belajar',
                        'c' => 'mempertahankan cara lama saja',
                        'd' => 'mengalihkan perubahan kepada orang lain',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Jika Anda ditugaskan mendampingi masyarakat dalam program sosial, sikap yang paling penting adalah . . .',
                    'options' => [
                        'a' => 'mendikte mereka apa yang harus dilakukan',
                        'b' => 'mendengarkan kebutuhan dan membantu solusinya',
                        'c' => 'mengabaikan aspirasi mereka',
                        'd' => 'mengatur tanpa melibatkan masyarakat',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Ketaatan terhadap norma sosial di tempat kerja menunjukkan . . .',
                    'options' => [
                        'a' => 'sikap acuh',
                        'b' => 'sikap profesional',
                        'c' => 'sikap egois',
                        'd' => 'sikap tidak peduli',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Salah satu indikator pelayanan prima adalah . . .',
                    'options' => [
                        'a' => 'respon lambat terhadap keluhan',
                        'b' => 'kejelasan prosedur dan kesopanan',
                        'c' => 'persyaratan sulit dan rumit',
                        'd' => 'biaya tinggi tanpa alasan',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Etika kerja yang baik antara lain adalah . . .',
                    'options' => [
                        'a' => 'menyelesaikan pekerjaan setengah hati',
                        'b' => 'berusaha maksimal dan jujur',
                        'c' => 'mengabaikan hasil',
                        'd' => 'berbohong agar terlihat rajin',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Dalam tim, komunikasi yang efektif ditandai dengan . . .',
                    'options' => [
                        'a' => 'berbicara tanpa mendengar',
                        'b' => 'mendengarkan dan memberi informasi jelas',
                        'c' => 'mengirim pesan membingungkan',
                        'd' => 'menghindari diskusi',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Jika tugas Anda tertunda karena gangguan teknis, tindakan yang paling tepat adalah . . .',
                    'options' => [
                        'a' => 'mengabaikannya',
                        'b' => 'memberitahu atasan dan mencari solusi',
                        'c' => 'menyalahkan rekan kerja',
                        'd' => 'menyelesaikan tugas besok saja',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Setiap pegawai publik wajib menjaga . . .',
                    'options' => [
                        'a' => 'keuntungan pribadi',
                        'b' => 'kepercayaan masyarakat',
                        'c' => 'kerahasiaan rekan kerja',
                        'd' => 'popularitas media',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Konsep “melayani masyarakat” berarti . . .',
                    'options' => [
                        'a' => 'menyampaikan semua aturan tanpa membantu',
                        'b' => 'membantu dengan ramah dan profesional',
                        'c' => 'memberi prioritas pada keluarga sendiri',
                        'd' => 'mengutamakan keuntungan instansi',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Jika Anda mendapatkan informasi penting, Anda harus . . .',
                    'options' => [
                        'a' => 'menyimpannya sendiri',
                        'b' => 'membagikannya secara langsung kepada pihak terkait',
                        'c' => 'menyebarkannya tanpa jelas tujuan',
                        'd' => 'mengabaikannya',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Salah satu bentuk tanggung jawab sosial pegawai adalah . . .',
                    'options' => [
                        'a' => 'mengabaikan hak masyarakat',
                        'b' => 'melakukan tugas sesuai peraturan dan peduli lingkungan',
                        'c' => 'memprioritaskan keuntungan pribadi',
                        'd' => 'menunda laporan',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Ketika keadaan penting, kepemimpinan yang baik adalah . . .',
                    'options' => [
                        'a' => 'menunggu instruksi terus',
                        'b' => 'bertindak tegas dan bertanggung jawab',
                        'c' => 'mengalihkan keputusan',
                        'd' => 'menghindar dari tanggung jawab',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Pelayanan publik yang adil ditandai oleh . . .',
                    'options' => [
                        'a' => 'memprioritaskan orang tertentu',
                        'b' => 'pelayanan tanpa diskriminasi',
                        'c' => 'syarat bermacam-macam bagi orang lain',
                        'd' => 'biaya layanan tinggi bagi sebagian orang',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Seorang pegawai mencoba memperbaiki dirinya setelah kritik. Hal ini menunjukkan . . .',
                    'options' => [
                        'a' => 'keangkuhan',
                        'b' => 'kemauan berkembang',
                        'c' => 'kepasifan',
                        'd' => 'ketidaktahuan',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Salah satu contoh kerja sama tim yang baik adalah . . .',
                    'options' => [
                        'a' => 'setiap anggota bekerja sendiri-sendiri',
                        'b' => 'membagi peran dan saling membantu',
                        'c' => 'mengabaikan saran orang lain',
                        'd' => 'berebut tugas penting',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Sikap adaptif terhadap teknologi baru dalam pekerjaan menunjukkan . . .',
                    'options' => [
                        'a' => 'menolak teknologi',
                        'b' => 'persiapan dan pembelajaran terus menerus',
                        'c' => 'mengandalkan cara lama selamanya',
                        'd' => 'mengabaikan perkembangan',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Contoh tindakan yang menunjukkan tanggung jawab moral adalah . . .',
                    'options' => [
                        'a' => 'melakukan kecurangan demi keuntungan',
                        'b' => 'mengembalikan barang hilang kepada pemiliknya',
                        'c' => 'mencuri hak orang lain',
                        'd' => 'mengabaikan orang yang kesusahan',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Membangun etos kerja yang baik berarti . . .',
                    'options' => [
                        'a' => 'mengerjakan tugas ala kadarnya',
                        'b' => 'berusaha maksimal dan disiplin',
                        'c' => 'menunda pekerjaan terus',
                        'd' => 'menghindari tugas sulit',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Jika informasi yang Anda terima tidak jelas, tindakan paling tepat adalah . . .',
                    'options' => [
                        'a' => 'melakukan sesuai asumsi sendiri',
                        'b' => 'meminta klarifikasi terlebih dahulu',
                        'c' => 'mengabaikannya',
                        'd' => 'menyebarkan informasi tanpa pasti',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Sikap berorientasi pada pelayanan publik adalah . . .',
                    'options' => [
                        'a' => 'fokus pada tugas pribadi saja',
                        'b' => 'memprioritaskan kebutuhan masyarakat',
                        'c' => 'memendam keluhan pengguna',
                        'd' => 'mengurangi kualitas layanan',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Berpikir kritis dalam menyelesaikan masalah berarti . . .',
                    'options' => [
                        'a' => 'menerima informasi tanpa pertanyaan',
                        'b' => 'menganalisis fakta sebelum mengambil keputusan',
                        'c' => 'bertindak berdasarkan emosi saja',
                        'd' => 'meniru keputusan orang lain',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Kepedulian terhadap lingkungan kerja tercermin dalam . . .',
                    'options' => [
                        'a' => 'membuang sampah sembarangan',
                        'b' => 'menjaga kebersihan dan kenyamanan',
                        'c' => 'membiarkan fasilitas rusak',
                        'd' => 'mengabaikan keamanan',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Seorang pegawai bekerja sama dengan pihak lain demi hasil terbaik. Ini menunjukkan . . .',
                    'options' => [
                        'a' => 'egoisme',
                        'b' => 'kolaborasi',
                        'c' => 'kompetisi berlebihan',
                        'd' => 'individualisme',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Sikap jujur di tempat kerja terlihat ketika . . .',
                    'options' => [
                        'a' => 'melaporkan prestasi teman sebagai milik sendiri',
                        'b' => 'mengakui sumber informasi dengan benar',
                        'c' => 'menyembunyikan kekurangan pekerjaan',
                        'd' => 'memanipulasi data',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Jika terjadi konflik antara rekan kerja, sikap yang paling bertanggung jawab adalah . . .',
                    'options' => [
                        'a' => 'menjadi provokator',
                        'b' => 'mendengarkan kedua pihak dan membantu mencari solusi',
                        'c' => 'memihak tanpa alasan',
                        'd' => 'mengabaikan masalah',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Menunjukkan semangat kebersamaan di kantor dapat dilakukan dengan . . .',
                    'options' => [
                        'a' => 'bergosip tentang orang lain',
                        'b' => 'mendukung dan membantu rekan',
                        'c' => 'mencari celah untuk menjatuhkan kolega',
                        'd' => 'mengambil kredit atas pekerjaan bersama',
                    ],
                    'correct' => 'b',
                ],
                [
                    'question_text' => 'Salah satu tanda profesionalisme adalah . . .',
                    'options' => [
                        'a' => 'menghadiri rapat tanpa persiapan',
                        'b' => 'mematuhi etika dan menjalankan tugas dengan baik',
                        'c' => 'menunda tanggung jawab',
                        'd' => 'mengeluh terus-menerus',
                    ],
                    'correct' => 'b',
                ],
            ],
        ];

        foreach ($examBank as $categoryName => $questions) {
            $category = Category::firstOrCreate([
                'name' => $categoryName,
            ], [
                'passing_grade_score' => match ($categoryName) {
                    'TWK' => 65,
                    'TIU' => 70,
                    'TKP' => 75,
                    default => 60,
                },
            ]);

            foreach ($questions as $questionData) {
                $question = Question::create([
                    'tryout_id' => $tryout->id,
                    'category_id' => $category->id,
                    'question_text' => $questionData['question_text'],
                    'discussion' => 'Jawaban benar adalah ' . strtoupper($questionData['correct']) . ' karena pilihan tersebut paling tepat.',
                ]);

                foreach ($questionData['options'] as $key => $optionText) {
                    QuestionOption::create([
                        'question_id' => $question->id,
                        'option_text' => $optionText,
                        'point' => $key === $questionData['correct'] ? 5 : 0,
                    ]);
                }
            }
        }
    }
}
