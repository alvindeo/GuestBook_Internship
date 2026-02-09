<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-black text-3xl text-deep-maroon leading-tight tracking-tighter uppercase">
                <span class="text-primary-red">Arsip</span> Kunjungan Tamu
            </h2>
            <div class="flex items-center gap-3">
                <form method="GET" action="{{ route('reports') }}" id="periodForm">
                    <div class="relative group">
                        <select name="periode" onchange="this.form.submit()" 
                            class="appearance-none bg-white border-2 border-tan/30 rounded-2xl px-6 py-3 pr-10 text-deep-maroon font-black uppercase text-xs tracking-widest focus:ring-2 focus:ring-primary-red focus:border-transparent transition-all shadow-sm cursor-pointer hover:border-primary-red">
                            <option value="week" {{ $periode == 'week' ? 'selected' : '' }}>Rekapan Minggu Ini</option>
                            <option value="month" {{ $periode == 'month' ? 'selected' : '' }}>Rekapan Bulan Ini</option>
                            <option value="year" {{ $periode == 'year' ? 'selected' : '' }}>Rekapan Tahun Ini</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-primary-red">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"></path></svg>
                        </div>
                    </div>
                </form>
                
                <button onclick="exportToExcel()" class="bg-primary-red text-cream px-8 py-3 rounded-2xl font-black uppercase text-xs tracking-widest hover:bg-deep-maroon transition-all shadow-lg shadow-primary-red/20 flex items-center gap-2 border-b-4 border-deep-maroon active:border-b-0 active:translate-y-[4px]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Export Data
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-cream min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-[40px] overflow-hidden shadow-2xl border-2 border-tan/20">
                <div class="p-8 border-b-2 border-cream bg-white">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-tan/20 rounded-2xl text-deep-maroon">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-deep-maroon uppercase tracking-tighter">Database Kunjungan</h3>
                            <p class="text-tan text-xs font-bold uppercase tracking-widest">Menampilkan {{ count($reports) }} entri data</p>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table id="reportTable" class="min-w-full">
                        <thead>
                            <tr class="bg-cream/50">
                                <th class="px-8 py-5 text-left text-[10px] font-black text-tan uppercase tracking-[0.2em] border-b-2 border-cream">Profil Pengunjung</th>
                                <th class="px-8 py-5 text-left text-[10px] font-black text-tan uppercase tracking-[0.2em] border-b-2 border-cream">Asal Instansi</th>
                                <th class="px-8 py-5 text-left text-[10px] font-black text-tan uppercase tracking-[0.2em] border-b-2 border-cream">Waktu Kunjungan</th>
                                <th class="px-8 py-5 text-center text-[10px] font-black text-tan uppercase tracking-[0.2em] border-b-2 border-cream">Status</th>
                                <th class="px-8 py-5 text-center text-[10px] font-black text-tan uppercase tracking-[0.2em] border-b-2 border-cream">Durasi</th>
                                <th class="px-8 py-5 text-left text-[10px] font-black text-tan uppercase tracking-[0.2em] border-b-2 border-cream">Keterangan / Tujuan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-cream">
                            @foreach($reports as $r)
                            <tr class="hover:bg-cream/20 transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="font-black text-deep-maroon text-lg group-hover:text-primary-red transition-colors">{{ $r->pengunjung->nama }}</div>
                                    <div class="text-tan text-xs font-bold flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1c-8.284 0-15-6.716-15-15V5z"></path></svg>
                                        {{ $r->pengunjung->no_hp }}
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="px-4 py-1 bg-tan/10 text-deep-maroon rounded-full text-xs font-black uppercase tracking-widest border border-tan/20">
                                        {{ $r->pengunjung->asal_institusi }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                            <span class="text-xs font-black text-deep-maroon italic">{{ \Carbon\Carbon::parse($r->tanggal_jam_masuk)->format('d M Y, H:i') }}</span>
                                        </div>
                                        @if($r->tanggal_jam_keluar)
                                        <div class="flex items-center gap-2 opacity-50">
                                            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                            <span class="text-xs font-black text-deep-maroon italic">{{ \Carbon\Carbon::parse($r->tanggal_jam_keluar)->format('d M Y, H:i') }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <form action="{{ route('reports.updateStatus', $r->id_kunjungan) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" 
                                            class="appearance-none bg-cream border-2 border-tan/30 rounded-xl px-4 py-2 text-[10px] font-black uppercase tracking-widest focus:ring-2 focus:ring-primary-red focus:border-transparent transition-all cursor-pointer {{ $r->status == 'IN' ? 'text-emerald-600 border-emerald-200' : 'text-rose-600 border-rose-200' }}">
                                            <option value="IN" {{ $r->status == 'IN' ? 'selected' : '' }}>DI DALAM</option>
                                            <option value="OUT" {{ $r->status == 'OUT' ? 'selected' : '' }}>KELUAR</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <div class="inline-flex flex-col items-center p-3 bg-cream rounded-2xl border-2 border-tan/20 min-w-[80px]">
                                        <span class="text-2xl font-black text-primary-red leading-none">{{ $r->durasi_kunjungan ?? 0 }}</span>
                                        <span class="text-[8px] font-black text-tan uppercase mt-1">MENIT</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="max-w-[250px] text-sm font-bold text-deep-maroon/70 italic leading-relaxed">
                                        "{{ $r->keperluan }}"
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @if(count($reports) == 0)
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center gap-4 opacity-20">
                                        <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                        <p class="text-2xl font-black uppercase tracking-tighter">Tidak Ada Data Ditemukan</p>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            
            <p class="mt-8 text-center text-tan text-[10px] font-black uppercase tracking-[0.5em] italic">Electronic Archive Maintenance Division</p>
        </div>
    </div>

    <script>
        function exportToExcel() {
            let table = document.getElementById("reportTable");
            let rows = Array.from(table.rows);
            let csvContent = "data:text/csv;charset=utf-8,";

            rows.forEach(row => {
                let rowData = Array.from(row.cells).map(cell => '"' + cell.innerText.replace(/\n/g, ' ').trim() + '"').join(",");
                csvContent += rowData + "\r\n";
            });

            let encodedUri = encodeURI(csvContent);
            let link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "Laporan_Kunjungan_{{ strtoupper($periode) }}_{{ date('dmy') }}.csv");
            document.body.appendChild(link);
            link.click();
        }
    </script>
</x-app-layout>
