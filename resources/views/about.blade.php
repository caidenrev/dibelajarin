<x-app-layout>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .team-front:hover .team-card-overlay {
            opacity: 1;
        }

        .team-front:hover img {
            transform: scale(1.05);
        }

        .team-card {
            perspective: 1000px; 
        }

        .card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            transition: transform 0.6s;
            transform-style: preserve-3d;
        }

        .team-card.is-flipped .card-inner {
            transform: rotateY(180deg);
        }

        .team-front, .team-back {
            position: absolute;
            width: 100%;
            height: 100%;
            -webkit-backface-visibility: hidden; 
            backface-visibility: hidden;
            border-radius: 1rem;
            overflow: hidden; 
        }

        .team-back {
            transform: rotateY(180deg); 
        }

    </style>

    <div class="py-12 sm:py-20 bg-gradient-to-b from-blue-50 to-white dark:from-slate-900 dark:to-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-16">
                <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 dark:text-white leading-tight mb-4">
                    Mengenal Kami Lebih Dekat
                </h1>
                <p class="text-lg text-slate-600 dark:text-slate-400 max-w-3xl mx-auto">
                    Kami adalah platform pembelajaran online yang dirancang untuk membantu Anda membuka potensi terbaik dalam dunia pendidikan dan teknologi.
                </p>
            </div>

            <div class="bg-white dark:bg-slate-800/50 overflow-hidden shadow-2xl shadow-blue-500/10 rounded-3xl p-8 sm:p-12">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-16">
                    {{-- Konten Visi & Misi Anda (Tidak diubah) --}}
                    <div class="space-y-4">
                        <h2 class="text-3xl font-bold text-slate-900 dark:text-white flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            Visi Kami
                        </h2>
                        <p class="text-slate-600 dark:text-slate-400 text-base leading-relaxed">
                            Menjadi platform pembelajaran online terdepan yang memberikan akses pendidikan berkualitas untuk semua kalangan, membantu mengembangkan potensi setiap individu untuk mencapai kesuksesan dalam karir dan kehidupan mereka.
                        </p>
                    </div>
                    <div class="space-y-4">
                        <h2 class="text-3xl font-bold text-slate-900 dark:text-white flex items-center">
                           <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Misi Kami
                        </h2>
                        <p class="text-slate-600 dark:text-slate-400 text-base leading-relaxed">
                            Menyediakan konten pembelajaran yang berkualitas, interaktif, dan relevan dengan kebutuhan industri. Membangun komunitas pembelajar yang aktif dan saling mendukung dalam proses pembelajaran.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20">
                    {{-- Konten Features Anda (Tidak diubah) --}}
                    <div class="p-6 bg-slate-50 dark:bg-slate-700/50 rounded-2xl transform hover:-translate-y-2 transition-transform duration-300"><div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/50 text-blue-500 rounded-lg flex items-center justify-center mb-4"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg></div><h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Kursus Berkualitas</h3><p class="text-slate-600 dark:text-slate-400">Materi pembelajaran yang dirancang oleh para ahli di bidangnya.</p></div>
                    <div class="p-6 bg-slate-50 dark:bg-slate-700/50 rounded-2xl transform hover:-translate-y-2 transition-transform duration-300"><div class="w-12 h-12 bg-green-100 dark:bg-green-900/50 text-green-500 rounded-lg flex items-center justify-center mb-4"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg></div><h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Instruktur Ahli</h3><p class="text-slate-600 dark:text-slate-400">Dibimbing oleh instruktur yang ahli dan berpengalaman.</p></div>
                    <div class="p-6 bg-slate-50 dark:bg-slate-700/50 rounded-2xl transform hover:-translate-y-2 transition-transform duration-300"><div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/50 text-purple-500 rounded-lg flex items-center justify-center mb-4"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg></div><h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Pembelajaran Fleksibel</h3><p class="text-slate-600 dark:text-slate-400">Belajar kapan saja dan di mana saja sesuai kebutuhan Anda.</p></div>
                </div>

                <div class="text-center mb-16">
                    <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white mb-4">Tim di Balik Layar <span>Di<span class="text-blue-400">Belajar</span>.In</span></h2>
                    <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">Kami adalah tim yang bersemangat dalam membangun solusi pendidikan terbaik.</p>
                </div>
                
                {{-- == [START] KODE HTML TIM YANG DIMODIFIKASI == --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-8">
                <div class="team-card aspect-square w-full">
                    <div class="card-inner h-full">
                        <div class="team-front shadow-lg rounded-2xl h-full">
                            <img src="{{ asset('images/isak.png') }}" alt="Foto Fredy Fajar" class="w-full h-full object-cover transition-transform duration-300 rounded-2xl">
                            <div class="team-card-overlay absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex flex-col justify-end p-6 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl">
                                <div>
                                    <h3 class="text-2xl font-bold text-white">Fredy Fajar</h3>
                                    <p class="text-blue-300 font-medium">System Engineer</p>
                                </div>
                                <button class="toggle-bio-btn mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors duration-300 self-start">Lihat Bio</button>
                            </div>
                        </div>
                        <div class="team-back bg-blue-800 text-white p-6 flex flex-col justify-center shadow-lg h-full rounded-2xl">
                            <h4 class="text-xl font-bold mb-2">Fredy Fajar</h4>
                            <ul class="space-y-2 text-slate-300">
                                <li><strong>Posisi:</strong> Backend Engineer | Founder</li>
                                <li><strong>Keahlian:</strong> PHP, Laravel, Node.js, MySQL</li>
                                <li><strong>Motto:</strong> "Clean code always looks like it was written by someone who cares."</li>
                            </ul>
                            <button class="toggle-bio-btn mt-6 px-4 py-2 bg-blue-500 rounded-lg hover:bg-blue-600 transition-colors duration-300 self-start">Kembali</button>
                        </div>
                    </div>
                </div>

                <div class="team-card aspect-square w-full">
                    <div class="card-inner h-full">
                        <div class="team-front shadow-lg rounded-2xl h-full">
                            <img src="{{ asset('images/revan.jpg') }}" alt="Foto Eka Revandi" class="w-full h-full object-cover transition-transform duration-300 rounded-2xl">
                            <div class="team-card-overlay absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex flex-col justify-end p-6 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl">
                                <div>
                                    <h3 class="text-2xl font-bold text-white">Eka Revandi</h3>
                                    <p class="text-orange-300 font-medium">Software Engineer | Founder</p>
                                </div>
                                <button class="toggle-bio-btn mt-4 px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors duration-300 self-start">Lihat Bio</button>
                            </div>
                        </div>
                        <div class="team-back bg-orange-900 text-white p-6 flex flex-col justify-center shadow-lg h-full rounded-2xl">
                            <h4 class="text-xl font-bold mb-2">Eka Revandi</h4>
                            <ul class="space-y-2 text-white">
                                <li><strong>CallName:</strong> Revan</li>
                                <li><strong>Posisi:</strong> Frontend Engineer</li>
                                <li><strong>Keahlian:</strong> React.js, Next.js, AWS, Cloud Engineer</li>
                                <li><strong>Motto:</strong> "The best way to predict the future is to create it."</li>
                            </ul>
                            <button class="toggle-bio-btn mt-6 px-4 py-2 bg-yellow-600 rounded-lg hover:bg-yellow-700 text-white transition-colors duration-300 self-start">Kembali</button>
                        </div>
                    </div>
                </div>
            </div>
                {{-- == [END] KODE HTML TIM YANG DIMODIFIKASI == --}}   
            </div>
        </div>
    </div>

    {{-- == [START] KODE JAVASCRIPT UNTUK FUNGSI FLIP == --}}
    <script>
        // Pastikan script berjalan setelah semua elemen HTML dimuat
        document.addEventListener('DOMContentLoaded', function () {
            // Pilih semua tombol yang berfungsi untuk membalik kartu
            const toggleButtons = document.querySelectorAll('.toggle-bio-btn');

            toggleButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    // Mencegah event dari elemen lain terpicu
                    e.stopPropagation(); 
                    
                    const teamCard = button.closest('.team-card');
                    
                    if (teamCard) {
                        teamCard.classList.toggle('is-flipped');
                    }
                });
            });
        });
    </script>
</x-app-layout>