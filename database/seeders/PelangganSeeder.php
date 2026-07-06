<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    public function run(): void
    {
        $pelanggans = [
            ['nama_pelanggan' => 'PT Maju Bersama',       'alamat' => 'Jl. Sudirman No. 45, Jakarta Pusat',        'telepon' => '021-55512345', 'email' => 'admin@majubersama.co.id'],
            ['nama_pelanggan' => 'CV Sinar Jaya',          'alamat' => 'Jl. Gatot Subroto No. 12, Bandung',         'telepon' => '022-87654321', 'email' => 'info@sinarjaya.com'],
            ['nama_pelanggan' => 'PT Teknologi Nusantara',  'alamat' => 'Jl. TB Simatupang No. 88, Jakarta Selatan', 'telepon' => '021-78901234', 'email' => 'contact@teknusa.id'],
            ['nama_pelanggan' => 'Toko Elektronik Jaya',    'alamat' => 'Jl. Pasar Baru No. 23, Surabaya',           'telepon' => '031-55443322', 'email' => 'toko@elektronikjaya.com'],
            ['nama_pelanggan' => 'PT Sentosa Abadi',        'alamat' => 'Jl. Ahmad Yani No. 100, Semarang',          'telepon' => '024-76543210', 'email' => 'hrd@sentosaabadi.co.id'],
            ['nama_pelanggan' => 'CV Berkah Mandiri',       'alamat' => 'Jl. Diponegoro No. 55, Yogyakarta',         'telepon' => '0274-556677',  'email' => 'berkah.mandiri@gmail.com'],
            ['nama_pelanggan' => 'PT Global Teknik',        'alamat' => 'Jl. Raya Bogor KM 30, Depok',               'telepon' => '021-87112233', 'email' => 'sales@globalteknik.com'],
            ['nama_pelanggan' => 'UD Makmur Sejahtera',     'alamat' => 'Jl. Veteran No. 67, Malang',                'telepon' => '0341-223344',  'email' => 'ud.makmur@yahoo.co.id'],
            ['nama_pelanggan' => 'PT Indah Perkasa',        'alamat' => 'Jl. Pemuda No. 34, Medan',                  'telepon' => '061-44556677', 'email' => 'admin@indahperkasa.com'],
            ['nama_pelanggan' => 'CV Karya Utama',          'alamat' => 'Jl. Imam Bonjol No. 78, Denpasar',          'telepon' => '0361-998877',  'email' => 'cv.karyautama@gmail.com'],
            ['nama_pelanggan' => 'PT Bumi Pangan Lestari',  'alamat' => 'Jl. Raya Cibubur No. 5, Bekasi',            'telepon' => '021-84455667', 'email' => 'order@bumipangan.co.id'],
            ['nama_pelanggan' => 'Toko Bangunan Mitra',     'alamat' => 'Jl. RE Martadinata No. 99, Tangerang',      'telepon' => '021-55667788', 'email' => 'mitra.bangunan@gmail.com'],
            ['nama_pelanggan' => 'PT Citra Kreasi Digital',  'alamat' => 'Jl. Kebon Jeruk Raya No. 12, Jakarta Barat','telepon' => '021-53344556', 'email' => 'hello@citrakreasi.id'],
            ['nama_pelanggan' => 'CV Anugerah Bersama',     'alamat' => 'Jl. Panglima Sudirman No. 20, Surabaya',    'telepon' => '031-99887766', 'email' => 'anugerah@bersama.co.id'],
            ['nama_pelanggan' => 'PT Omega Solusi',         'alamat' => 'Jl. Asia Afrika No. 45, Bandung',           'telepon' => '022-42233445', 'email' => 'info@omegasolusi.com'],
            ['nama_pelanggan' => 'UD Sumber Rezeki',        'alamat' => 'Jl. KH Hasyim Ashari No. 33, Tangerang',    'telepon' => '021-55112233', 'email' => 'sumberrezeki@gmail.com'],
            ['nama_pelanggan' => 'PT Prima Logistics',      'alamat' => 'Jl. Raya Bekasi KM 25, Bekasi',             'telepon' => '021-88990011', 'email' => 'ops@primalogistics.co.id'],
            ['nama_pelanggan' => 'CV Harapan Mulia',        'alamat' => 'Jl. Mayjen Sungkono No. 89, Surabaya',      'telepon' => '031-77665544', 'email' => 'harapanmulia@yahoo.com'],
            ['nama_pelanggan' => 'PT Rajawali Sakti',       'alamat' => 'Jl. Cendrawasih No. 15, Makassar',          'telepon' => '0411-3344556', 'email' => 'rajawali@sakti.co.id'],
            ['nama_pelanggan' => 'Toko Komputer Megabyte',  'alamat' => 'Jl. Mangga Dua Raya No. 10, Jakarta Utara', 'telepon' => '021-62233445', 'email' => 'sales@megabyte.co.id'],
            ['nama_pelanggan' => 'PT Aneka Mineral',        'alamat' => 'Jl. Raya Cikarang No. 77, Bekasi',          'telepon' => '021-89001234', 'email' => 'info@anekamineral.com'],
            ['nama_pelanggan' => 'CV Lestari Agro',         'alamat' => 'Jl. Raya Puncak No. 50, Bogor',             'telepon' => '0251-8334455', 'email' => 'cv.lestariagro@gmail.com'],
            ['nama_pelanggan' => 'PT Dinamika Pratama',     'alamat' => 'Jl. HR Rasuna Said No. 22, Jakarta Selatan','telepon' => '021-52211334', 'email' => 'contact@dinamikapratama.id'],
            ['nama_pelanggan' => 'UD Sari Bumi',            'alamat' => 'Jl. Raya Darmo No. 60, Surabaya',           'telepon' => '031-56677889', 'email' => 'saribumi.ud@gmail.com'],
            ['nama_pelanggan' => 'PT Metro Infotama',       'alamat' => 'Jl. Jend. Sudirman No. 200, Palembang',     'telepon' => '0711-3556677', 'email' => 'admin@metroinfotama.co.id'],
        ];

        foreach ($pelanggans as $data) {
            Pelanggan::create($data);
        }
    }
}
