<x-guest-layout>
    <div class="min-h-screen relative overflow-hidden bg-cream flex items-center justify-center p-4">
        <!-- Abstract Decorative Elements -->
        <div class="absolute top-[-5%] right-[-5%] w-[30%] h-[30%] bg-tan/30 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-[-5%] left-[-5%] w-[30%] h-[30%] bg-primary-red/10 rounded-full blur-[100px]"></div>

        <div class="w-full max-w-lg relative">
            <!-- Main Container -->
            <div class="bg-white border-2 border-tan rounded-[40px] shadow-2xl p-8 md:p-12 overflow-hidden">
                
                <div class="text-center mb-10">
                    <div class="inline-flex p-4 bg-primary-red rounded-3xl shadow-lg shadow-primary-red/30 mb-6">
                        <svg class="w-10 h-10 text-cream" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-4xl font-black text-deep-maroon mb-2 tracking-tight">Buku Kunjungan Tamu</h2>
                    <p class="text-tan font-black uppercase tracking-[0.2em] text-xs">Sistem Registrasi Pengunjung</p>
                </div>

                @if(session('success'))
                    <div class="alert-message bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-3xl mb-8 flex items-center gap-4 animate-in fade-in zoom-in duration-300">
                        <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-bold">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert-message bg-primary-red/10 border border-primary-red/20 text-primary-red px-6 py-4 rounded-3xl mb-8 flex items-center gap-4 animate-in fade-in zoom-in duration-300">
                        <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-bold">{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Welcome Back Alert -->
                <div id="welcome-msg" class="hidden bg-tan/20 border-2 border-tan text-deep-maroon px-6 py-4 rounded-3xl mb-8 items-center gap-4 animate-bounce">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span id="welcome-text" class="font-black italic"></span>
                </div>

                <!-- Registration Form -->
                <form method="POST" action="{{ route('guestbook.store') }}" id="guestbook-form" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-tan text-[10px] uppercase font-black tracking-widest mb-2 ml-4">Nomor WhatsApp / HP</label>
                        <input id="no_hp" type="text" name="no_hp" required autofocus
                            inputmode="numeric"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            class="w-full bg-cream/30 border-2 border-tan/50 rounded-2xl px-6 py-4 text-deep-maroon placeholder-tan focus:outline-none focus:ring-2 focus:ring-primary-red focus:border-transparent transition-all font-bold"
                            placeholder="Contoh: 0812XXXXXXXX">
                        <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
                    </div>

                    <div>
                        <label class="block text-tan text-[10px] uppercase font-black tracking-widest mb-2 ml-4">Nama Lengkap</label>
                        <input id="nama" type="text" name="nama" required
                            class="w-full bg-cream/30 border-2 border-tan/50 rounded-2xl px-6 py-4 text-deep-maroon focus:outline-none focus:ring-2 focus:ring-primary-red transition-all font-bold">
                        <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                    </div>

                    <div>
                        <label class="block text-tan text-[10px] uppercase font-black tracking-widest mb-2 ml-4">Asal Institusi</label>
                        <input id="asal_institusi" type="text" name="asal_institusi" required
                            class="w-full bg-cream/30 border-2 border-tan/50 rounded-2xl px-6 py-4 text-deep-maroon focus:outline-none focus:ring-2 focus:ring-primary-red transition-all font-bold">
                        <x-input-error :messages="$errors->get('asal_institusi')" class="mt-2" />
                    </div>

                    <div>
                        <label class="block text-tan text-[10px] uppercase font-black tracking-widest mb-2 ml-4">Tujuan / Keperluan</label>
                        <textarea id="keperluan" name="keperluan" required rows="3"
                            class="w-full bg-cream/30 border-2 border-tan/50 rounded-2xl px-6 py-4 text-deep-maroon placeholder-tan focus:outline-none focus:ring-2 focus:ring-primary-red transition-all font-bold resize-none"
                            placeholder="Jelaskan kebutuhan Anda..."></textarea>
                    </div>

                    <button type="submit" class="w-full bg-primary-red hover:bg-deep-maroon text-cream font-black py-5 rounded-3xl shadow-xl shadow-primary-red/30 transition-all hover:translate-y-[-2px] active:translate-y-[1px]">
                        KONFIRMASI CHECK-IN
                    </button>
                </form>

                <!-- Checkout Form (Hidden) -->
                <form id="checkout-form" method="POST" action="{{ route('guestbook.checkout') }}" class="hidden space-y-6">
                    @csrf
                    <div>
                        <label class="block text-tan text-[10px] uppercase font-black tracking-widest mb-2 ml-4">Nomor HP Saat Check-in</label>
                        <input id="checkout_no_hp" type="text" name="no_hp" required
                            class="w-full bg-cream/30 border-2 border-tan/50 rounded-2xl px-6 py-4 text-deep-maroon focus:outline-none focus:ring-2 focus:ring-deep-maroon transition-all font-bold">
                    </div>
                    <button type="submit" class="w-full bg-deep-maroon hover:bg-black text-cream font-black py-5 rounded-3xl shadow-xl shadow-deep-maroon/30 transition-all hover:translate-y-[-2px] active:translate-y-[1px]">
                        KONFIRMASI CHECK-OUT
                    </button>
                    <button type="button" onclick="showRegister()" class="w-full text-tan text-xs font-bold hover:text-deep-maroon transition-colors">
                        Batal, kembali ke pendaftaran
                    </button>
                </form>
            </div>
            
        </div>
    </div>

    <script>
        document.getElementById('no_hp').addEventListener('input', function() {
            let phone = this.value;
            if (phone.length >= 10) {
                this.classList.add('border-primary-red/50');
                
                fetch('{{ route('guestbook.checkPhone') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ no_hp: phone })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        document.getElementById('nama').value = data.nama;
                        document.getElementById('asal_institusi').value = data.asal_institusi;
                        document.getElementById('welcome-msg').style.display = 'flex';
                        document.getElementById('welcome-text').innerText = 'Selamat datang kembali, ' + data.nama + '!';
                        
                        document.querySelectorAll('input').forEach(i => {
                            if(i.value && i.id !== 'no_hp') i.classList.add('bg-tan/10');
                        });
                    } else {
                        document.getElementById('welcome-msg').style.display = 'none';
                        document.querySelectorAll('input').forEach(i => {
                            if(i.id !== 'no_hp') i.classList.remove('bg-tan/10');
                        });
                    }
                });
            }
        });

        function showCheckout() {
            document.getElementById('guestbook-form').classList.add('hidden');
            document.getElementById('checkout-form').classList.remove('hidden');
            document.getElementById('checkout-link-container').classList.add('hidden');
        }

        function showRegister() {
            document.getElementById('guestbook-form').classList.remove('hidden');
            document.getElementById('checkout-form').classList.add('hidden');
            document.getElementById('checkout-link-container').classList.remove('hidden');
        }

        // Auto-hide alert messages after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert-message');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.8s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 800);
            });
        }, 5000);
    </script>
</x-guest-layout>
