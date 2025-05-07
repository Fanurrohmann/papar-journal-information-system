<?php

namespace Database\Seeders;

use App\Models\Page;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{

    public function run()
    {
        // // Hapus data yang ada terlebih dahulu untuk menghindari duplikasi
        // DB::table('pages')->truncate();

        // Data untuk bahasa Indonesia (ID: 1)
        Page::create([
            'about_title' => 'Tentang Kami',
            'about_detail' => '<p><span data-start="77" data-end="92" style="font-weight: bolder;">Papar Media</span>&nbsp;lahir di Tuban, Jawa Timur untuk membawa cerita-cerita akar rumput ke permukaan. Kami percaya, kisah sederhana bisa menggerakkan perubahan. Lewat tulisan, kolaborasi ruang publik, dan layanan kreatif&nbsp;<span style="font-weight: bolder;">Papar Ndue Gawe</span>, kami menyambungkan suara warga dengan ruang dengar yang lebih luas.</p>',
            'about_status' => 'Show',
            'faq_title' => 'Tanya Jawab',
            'faq_detail' => '<p><br></p>',
            'faq_status' => 'Hide',
            'contact_title' => 'Hubungi Kami',
            'contact_detail' => '<p>Silakan hubungi kami melalui informasi di bawah ini.</p>',
            'contact_map' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387193.05061478255!2d-74.30916881109896!3d40.69719334890644!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sid!4v1744258911128!5m2!1sen!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            'contact_status' => 'Show',
            'terms_title' => 'Syarat dan Ketentuan',
            'terms_detail' => '<p data-start="141" data-end="588" class="">Pengguna diwajibkan untuk memahami dan menyetujui seluruh syarat dan ketentuan yang berlaku sebelum menggunakan layanan kami. Segala aktivitas yang dilakukan dalam platform ini harus sesuai dengan ketentuan yang telah ditetapkan, termasuk namun tidak terbatas pada penggunaan layanan secara wajar dan tidak merugikan pihak manapun. Kami tidak bertanggung jawab atas pelanggaran yang dilakukan oleh pengguna atas kebijakan yang telah kami tetapkan.</p><p data-start="590" data-end="987" class="">Dengan menggunakan layanan ini, pengguna menyetujui bahwa setiap data dan informasi yang diberikan adalah benar dan dapat dipertanggungjawabkan. Kami berhak untuk menolak, menghentikan, atau membatasi akses terhadap layanan apabila ditemukan pelanggaran terhadap kebijakan penggunaan. Kami juga berhak melakukan pembaruan atas syarat dan ketentuan ini sewaktu-waktu tanpa pemberitahuan sebelumnya.</p><p data-start="989" data-end="1359" class="">Kami berusaha semaksimal mungkin untuk menjaga kenyamanan dan keamanan pengguna selama menggunakan layanan kami. Namun, kami tidak menjamin bahwa layanan ini akan selalu bebas dari gangguan atau kesalahan teknis. Oleh karena itu, pengguna dianjurkan untuk menggunakan layanan dengan bijak dan bertanggung jawab penuh atas setiap tindakan yang dilakukan dalam sistem ini.</p><p>


</p><p data-start="1361" data-end="1610" class="">Segala bentuk pelanggaran terhadap syarat dan ketentuan ini akan diproses sesuai dengan hukum yang berlaku. Dengan melanjutkan penggunaan layanan ini, pengguna dianggap telah membaca, memahami, dan menyetujui semua isi dari syarat dan ketentuan ini.</p>',
            'terms_status' => 'Show',
            'privacy_title' => 'Kebijakan Privasi',
            'privacy_detail' => '<p data-start="141" data-end="588" class="">Pengguna diwajibkan untuk memahami dan menyetujui seluruh syarat dan ketentuan yang berlaku sebelum menggunakan layanan kami. Segala aktivitas yang dilakukan dalam platform ini harus sesuai dengan ketentuan yang telah ditetapkan, termasuk namun tidak terbatas pada penggunaan layanan secara wajar dan tidak merugikan pihak manapun. Kami tidak bertanggung jawab atas pelanggaran yang dilakukan oleh pengguna atas kebijakan yang telah kami tetapkan.</p><p data-start="590" data-end="987" class="">Dengan menggunakan layanan ini, pengguna menyetujui bahwa setiap data dan informasi yang diberikan adalah benar dan dapat dipertanggungjawabkan. Kami berhak untuk menolak, menghentikan, atau membatasi akses terhadap layanan apabila ditemukan pelanggaran terhadap kebijakan penggunaan. Kami juga berhak melakukan pembaruan atas syarat dan ketentuan ini sewaktu-waktu tanpa pemberitahuan sebelumnya.</p><p data-start="141" data-end="588" class="">Pengguna diwajibkan untuk memahami dan menyetujui seluruh syarat dan ketentuan yang berlaku sebelum menggunakan layanan kami. Segala aktivitas yang dilakukan dalam platform ini harus sesuai dengan ketentuan yang telah ditetapkan, termasuk namun tidak terbatas pada penggunaan layanan secara wajar dan tidak merugikan pihak manapun. Kami tidak bertanggung jawab atas pelanggaran yang dilakukan oleh pengguna atas kebijakan yang telah kami tetapkan.</p><p data-start="590" data-end="987" class="">Dengan menggunakan layanan ini, pengguna menyetujui bahwa setiap data dan informasi yang diberikan adalah benar dan dapat dipertanggungjawabkan. Kami berhak untuk menolak, menghentikan, atau membatasi akses terhadap layanan apabila ditemukan pelanggaran terhadap kebijakan penggunaan. Kami juga berhak melakukan pembaruan atas syarat dan ketentuan ini sewaktu-waktu tanpa pemberitahuan sebelumnya.</p>',
            'privacy_status' => 'Show',
            'disclaimer_title' => 'Disclaimer',
            'disclaimer_detail' => '<p data-start="141" data-end="588" class="">Pengguna diwajibkan untuk memahami dan menyetujui seluruh syarat dan ketentuan yang berlaku sebelum menggunakan layanan kami. Segala aktivitas yang dilakukan dalam platform ini harus sesuai dengan ketentuan yang telah ditetapkan, termasuk namun tidak terbatas pada penggunaan layanan secara wajar dan tidak merugikan pihak manapun. Kami tidak bertanggung jawab atas pelanggaran yang dilakukan oleh pengguna atas kebijakan yang telah kami tetapkan.</p><p data-start="590" data-end="987" class="">Dengan menggunakan layanan ini, pengguna menyetujui bahwa setiap data dan informasi yang diberikan adalah benar dan dapat dipertanggungjawabkan. Kami berhak untuk menolak, menghentikan, atau membatasi akses terhadap layanan apabila ditemukan pelanggaran terhadap kebijakan penggunaan. Kami juga berhak melakukan pembaruan atas syarat dan ketentuan ini sewaktu-waktu tanpa pemberitahuan sebelumnya.</p><p data-start="141" data-end="588" class="">Pengguna diwajibkan untuk memahami dan menyetujui seluruh syarat dan ketentuan yang berlaku sebelum menggunakan layanan kami. Segala aktivitas yang dilakukan dalam platform ini harus sesuai dengan ketentuan yang telah ditetapkan, termasuk namun tidak terbatas pada penggunaan layanan secara wajar dan tidak merugikan pihak manapun. Kami tidak bertanggung jawab atas pelanggaran yang dilakukan oleh pengguna atas kebijakan yang telah kami tetapkan.</p><p data-start="590" data-end="987" class="">Dengan menggunakan layanan ini, pengguna menyetujui bahwa setiap data dan informasi yang diberikan adalah benar dan dapat dipertanggungjawabkan. Kami berhak untuk menolak, menghentikan, atau membatasi akses terhadap layanan apabila ditemukan pelanggaran terhadap kebijakan penggunaan. Kami juga berhak melakukan pembaruan atas syarat dan ketentuan ini sewaktu-waktu tanpa pemberitahuan sebelumnya.</p>',
            'disclaimer_status' => 'Show',
            'login_title' => 'Login',
            'login_status' => 'Hide',
            'language_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        // Anda juga bisa menambahkan data untuk bahasa lain
        // Contoh untuk bahasa Inggris (ID: 2)
        // Page::create([
        //     'about_title' => 'About Us',
        //     'about_detail' => '<p>This is about us page. Please add your detailed description here.</p>',
        //     'about_status' => 'Show',
        //     'faq_title' => 'Frequently Asked Questions',
        //     'faq_detail' => '<p>This is FAQ page. Please add your questions and answers here.</p>',
        //     'faq_status' => 'Show',
        //     'contact_title' => 'Contact Us',
        //     'contact_detail' => '<p>Please contact us through the information below.</p>',
        //     'contact_map' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.054323847708!2d106.82196231476884!3d-6.2508482954733375!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f15f5a7f4d05%3A0x8f0a6935da6f0e3!2sMonumen%20Nasional!5e0!3m2!1sid!2sid!4v1620192598996!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
        //     'contact_status' => 'Show',
        //     'terms_title' => 'Terms and Conditions',
        //     'terms_detail' => '<p>This is terms and conditions page. Please add your terms and conditions details here.</p>',
        //     'terms_status' => 'Show',
        //     'privacy_title' => 'Privacy Policy',
        //     'privacy_detail' => '<p>This is privacy policy page. Please add your privacy policy details here.</p>',
        //     'privacy_status' => 'Show',
        //     'disclaimer_title' => 'Disclaimer',
        //     'disclaimer_detail' => '<p>This is disclaimer page. Please add your disclaimer information here.</p>',
        //     'disclaimer_status' => 'Show',
        //     'login_title' => 'Login',
        //     'login_status' => 'Show',
        //     'language_id' => 2,
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now()
        // ]);
    }
}
