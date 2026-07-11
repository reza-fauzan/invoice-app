<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $produks = [
            // Jasa IT & Digital (1-20)
            ['nama_produk' => 'Jasa Pembuatan Website Company Profile',  'harga' => 5500000],
            ['nama_produk' => 'Jasa Pembuatan Website E-Commerce',       'harga' => 12000000],
            ['nama_produk' => 'Jasa Pembuatan Aplikasi Mobile Android',  'harga' => 15000000],
            ['nama_produk' => 'Jasa Pembuatan Aplikasi Mobile iOS',      'harga' => 18000000],
            ['nama_produk' => 'Jasa Desain Logo',                        'harga' => 1500000],
            ['nama_produk' => 'Jasa Desain UI/UX',                       'harga' => 8000000],
            ['nama_produk' => 'Jasa SEO Optimization (per bulan)',       'harga' => 3000000],
            ['nama_produk' => 'Jasa Social Media Management (per bulan)','harga' => 4500000],
            ['nama_produk' => 'Jasa Maintenance Website (per bulan)',    'harga' => 1500000],
            ['nama_produk' => 'Jasa Pembuatan Sistem ERP',               'harga' => 50000000],
            ['nama_produk' => 'Jasa Instalasi Server',                   'harga' => 7500000],
            ['nama_produk' => 'Jasa Konfigurasi Jaringan',              'harga' => 3500000],
            ['nama_produk' => 'Jasa Data Recovery',                      'harga' => 2000000],
            ['nama_produk' => 'Jasa Migrasi Database',                   'harga' => 5000000],
            ['nama_produk' => 'Jasa Pembuatan API Integration',          'harga' => 7000000],
            ['nama_produk' => 'Jasa Cyber Security Audit',               'harga' => 10000000],
            ['nama_produk' => 'Jasa Cloud Setup & Migration',            'harga' => 8500000],
            ['nama_produk' => 'Jasa Video Editing Profesional',          'harga' => 2500000],
            ['nama_produk' => 'Jasa Foto Produk (per sesi)',             'harga' => 1800000],
            ['nama_produk' => 'Jasa Content Writing (10 artikel)',       'harga' => 2000000],

            // Hardware & Perangkat (21-45)
            ['nama_produk' => 'Laptop ASUS VivoBook 14',                 'harga' => 7999000],
            ['nama_produk' => 'Laptop Lenovo ThinkPad E14',              'harga' => 12500000],
            ['nama_produk' => 'Laptop HP Pavilion 15',                   'harga' => 9500000],
            ['nama_produk' => 'Monitor LG 27" 4K IPS',                   'harga' => 5200000],
            ['nama_produk' => 'Monitor Samsung 24" FHD',                 'harga' => 2800000],
            ['nama_produk' => 'Keyboard Mechanical Logitech G413',       'harga' => 1350000],
            ['nama_produk' => 'Mouse Wireless Logitech MX Master 3',     'harga' => 1499000],
            ['nama_produk' => 'Webcam Logitech C920 HD Pro',             'harga' => 1200000],
            ['nama_produk' => 'Headset Jabra Evolve2 40',                'harga' => 1850000],
            ['nama_produk' => 'Printer Epson L3250 Ink Tank',            'harga' => 3200000],
            ['nama_produk' => 'Printer HP LaserJet Pro M404dn',          'harga' => 5500000],
            ['nama_produk' => 'Scanner Epson DS-530 II',                 'harga' => 6800000],
            ['nama_produk' => 'Router Mikrotik RB750Gr3',                'harga' => 850000],
            ['nama_produk' => 'Switch Cisco SG350-28P',                  'harga' => 7200000],
            ['nama_produk' => 'Access Point Ubiquiti UniFi AP AC LR',    'harga' => 2100000],
            ['nama_produk' => 'UPS APC Back-UPS 1100VA',                 'harga' => 1650000],
            ['nama_produk' => 'SSD Samsung 870 EVO 1TB',                 'harga' => 1450000],
            ['nama_produk' => 'RAM DDR4 16GB Corsair Vengeance',         'harga' => 850000],
            ['nama_produk' => 'Hard Disk External 2TB Seagate',          'harga' => 950000],
            ['nama_produk' => 'Flash Drive SanDisk 64GB USB 3.0',        'harga' => 125000],
            ['nama_produk' => 'Kabel LAN Cat6 (per meter)',              'harga' => 8000],
            ['nama_produk' => 'Kabel HDMI 2.0 3 Meter',                 'harga' => 85000],
            ['nama_produk' => 'Docking Station USB-C 12-in-1',          'harga' => 750000],
            ['nama_produk' => 'Proyektor Epson EB-X51',                  'harga' => 7500000],
            ['nama_produk' => 'Tablet Samsung Galaxy Tab A8',            'harga' => 3999000],

            // Software & Lisensi (46-65)
            ['nama_produk' => 'Lisensi Microsoft Office 365 Business',   'harga' => 1800000],
            ['nama_produk' => 'Lisensi Windows 11 Pro',                  'harga' => 3200000],
            ['nama_produk' => 'Lisensi Adobe Creative Cloud (1 tahun)',  'harga' => 8500000],
            ['nama_produk' => 'Lisensi Antivirus Kaspersky (1 tahun)',   'harga' => 450000],
            ['nama_produk' => 'Domain .com (1 tahun)',                   'harga' => 150000],
            ['nama_produk' => 'Domain .co.id (1 tahun)',                 'harga' => 250000],
            ['nama_produk' => 'Hosting Shared (1 tahun)',                'harga' => 600000],
            ['nama_produk' => 'VPS Cloud 2 Core 4GB RAM (per bulan)',    'harga' => 350000],
            ['nama_produk' => 'VPS Cloud 4 Core 8GB RAM (per bulan)',    'harga' => 650000],
            ['nama_produk' => 'Dedicated Server (per bulan)',            'harga' => 2500000],
            ['nama_produk' => 'SSL Certificate (1 tahun)',               'harga' => 350000],
            ['nama_produk' => 'Email Hosting 10 Akun (1 tahun)',         'harga' => 500000],
            ['nama_produk' => 'Lisensi Zoom Business (per bulan)',       'harga' => 280000],
            ['nama_produk' => 'Google Workspace Business (per bulan)',    'harga' => 180000],
            ['nama_produk' => 'Lisensi AutoCAD LT (1 tahun)',            'harga' => 6500000],
            ['nama_produk' => 'Lisensi CorelDRAW Standard',              'harga' => 4200000],
            ['nama_produk' => 'Lisensi Figma Professional (per tahun)',  'harga' => 2000000],
            ['nama_produk' => 'Lisensi Notion Team (per bulan)',         'harga' => 120000],
            ['nama_produk' => 'Lisensi Slack Pro (per bulan)',           'harga' => 115000],
            ['nama_produk' => 'Lisensi GitHub Enterprise (per bulan)',   'harga' => 300000],

            // Peralatan Kantor (66-85)
            ['nama_produk' => 'Meja Kerja Kayu 120cm',                  'harga' => 1500000],
            ['nama_produk' => 'Kursi Kantor Ergonomis',                  'harga' => 2800000],
            ['nama_produk' => 'Kursi Gaming Premium',                    'harga' => 3500000],
            ['nama_produk' => 'Lemari Arsip 4 Laci',                    'harga' => 2200000],
            ['nama_produk' => 'Rak Buku Kayu 5 Tingkat',                'harga' => 850000],
            ['nama_produk' => 'Whiteboard Magnetic 120x90cm',           'harga' => 450000],
            ['nama_produk' => 'Papan Kork 90x60cm',                     'harga' => 180000],
            ['nama_produk' => 'Dispenser Galon Hot & Cool',              'harga' => 1200000],
            ['nama_produk' => 'AC Daikin 1 PK Inverter',                 'harga' => 5500000],
            ['nama_produk' => 'CCTV Hikvision 4 Channel Paket',         'harga' => 3200000],
            ['nama_produk' => 'Mesin Absensi Fingerprint',               'harga' => 2500000],
            ['nama_produk' => 'Brankas Digital Krisbow',                 'harga' => 3800000],
            ['nama_produk' => 'Telepon IP Grandstream GXP1625',          'harga' => 950000],
            ['nama_produk' => 'Standing Desk Electric',                  'harga' => 4500000],
            ['nama_produk' => 'Monitor Arm Dual Screen',                 'harga' => 650000],
            ['nama_produk' => 'Lampu Meja LED Desk Lamp',                'harga' => 250000],
            ['nama_produk' => 'Kertas HVS A4 70gr (5 rim)',              'harga' => 225000],
            ['nama_produk' => 'Tinta Printer Epson 003 Set CMYK',       'harga' => 180000],
            ['nama_produk' => 'Stapler Heavy Duty',                      'harga' => 120000],
            ['nama_produk' => 'Paper Shredder Cross Cut',                'harga' => 1800000],

            // Konsultasi & Training (86-100)
            ['nama_produk' => 'Konsultasi IT 1 Jam',                     'harga' => 500000],
            ['nama_produk' => 'Konsultasi IT 1 Hari (8 Jam)',            'harga' => 3500000],
            ['nama_produk' => 'Training Microsoft Excel Advanced',       'harga' => 2500000],
            ['nama_produk' => 'Training Digital Marketing',              'harga' => 3000000],
            ['nama_produk' => 'Training Web Development (3 Hari)',       'harga' => 7500000],
            ['nama_produk' => 'Training Cyber Security Awareness',       'harga' => 5000000],
            ['nama_produk' => 'Training Data Analytics & Power BI',      'harga' => 4500000],
            ['nama_produk' => 'Workshop UI/UX Design (2 Hari)',          'harga' => 6000000],
            ['nama_produk' => 'Training Project Management (PMP)',       'harga' => 8000000],
            ['nama_produk' => 'Konsultasi Infrastruktur Jaringan',       'harga' => 4000000],
            ['nama_produk' => 'Training Laravel & PHP Modern',           'harga' => 5500000],
            ['nama_produk' => 'Training DevOps & CI/CD',                 'harga' => 6500000],
            ['nama_produk' => 'Training React & Next.js (3 Hari)',       'harga' => 7000000],
            ['nama_produk' => 'Audit & Konsultasi Sistem IT',            'harga' => 15000000],
            ['nama_produk' => 'Support Teknis On-Site (per hari)',       'harga' => 1500000],
        ];

        foreach ($produks as $data) {
            Produk::create($data);
        }
    }
}
