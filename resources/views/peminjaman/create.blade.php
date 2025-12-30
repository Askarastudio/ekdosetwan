<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajukan Peminjaman Kendaraan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                <p class="text-sm text-red-700">{{ session('error') }}</p>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" x-data="peminjamanCalendar()">
                <div class="p-6">
                    <form action="{{ route('peminjaman.store') }}" method="POST" id="peminjamanForm">
                        @csrf

                        <div class="space-y-6">
                            <!-- Kendaraan -->
                            <div>
                                <label for="kendaraan_id" class="block text-sm font-medium text-gray-700">
                                    Pilih Kendaraan <span class="text-red-500">*</span>
                                </label>
                                <select name="kendaraan_id" id="kendaraan_id" required
                                    x-model="selectedKendaraan"
                                    @change="loadBookings()"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">-- Pilih Kendaraan --</option>
                                    @foreach($kendaraans as $kendaraan)
                                    <option value="{{ $kendaraan->id }}">
                                        {{ $kendaraan->merk }} {{ $kendaraan->tipe }} - {{ $kendaraan->nomor_polisi }} 
                                    </option>
                                    @endforeach
                                </select>
                                @error('kendaraan_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Interactive Calendar -->
                            <div x-show="selectedKendaraan" class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Set The Date</h3>
                                
                                <div class="flex items-center justify-between mb-6">
                                    <button type="button" @click="prevMonth()" class="p-2 hover:bg-gray-200 rounded">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                        </svg>
                                    </button>
                                    <h4 class="text-xl font-semibold" x-text="getMonthYearText()"></h4>
                                    <button type="button" @click="nextMonth()" class="p-2 hover:bg-gray-200 rounded">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Calendar Grid -->
                                <div class="grid grid-cols-7 gap-1">
                                    <!-- Day Headers -->
                                    <div class="text-center font-semibold text-xs text-red-600 py-2 border-b border-gray-200">Sun</div>
                                    <div class="text-center font-semibold text-xs text-gray-700 py-2 border-b border-gray-200">Mon</div>
                                    <div class="text-center font-semibold text-xs text-gray-700 py-2 border-b border-gray-200">Tue</div>
                                    <div class="text-center font-semibold text-xs text-gray-700 py-2 border-b border-gray-200">Wed</div>
                                    <div class="text-center font-semibold text-xs text-gray-700 py-2 border-b border-gray-200">Thu</div>
                                    <div class="text-center font-semibold text-xs text-gray-700 py-2 border-b border-gray-200">Fri</div>
                                    <div class="text-center font-semibold text-xs text-gray-700 py-2 border-b border-gray-200">Sat</div>
                                    
                                    <!-- Calendar Days -->
                                    <template x-for="(day, index) in calendarDays" :key="index">
                                        <div class="min-h-[50px] flex items-center justify-center">
                                            <button type="button"
                                                @click="selectDate(day)"
                                                :disabled="!day.isCurrentMonth || day.isPast || day.isBooked"
                                                class="w-full h-full min-h-[50px] flex flex-col items-center justify-center rounded-md border transition-all"
                                                :class="{
                                                    'bg-blue-600 text-white border-blue-700': day.isStart || day.isEnd,
                                                    'bg-blue-100 border-blue-200': day.isInRange && !day.isStart && !day.isEnd,
                                                    'text-gray-400 bg-white border-gray-100': !day.isCurrentMonth,
                                                    'text-gray-900 bg-white border-gray-200 hover:bg-gray-50': day.isCurrentMonth && !day.isPast && !day.isBooked && !day.isStart && !day.isEnd && !day.isInRange,
                                                    'text-red-600 bg-white border-gray-200 hover:bg-gray-50': day.isSunday && day.isCurrentMonth && !day.isPast && !day.isBooked && !day.isStart && !day.isEnd && !day.isInRange,
                                                    'opacity-30 cursor-not-allowed bg-gray-50 border-gray-200': day.isPast && day.isCurrentMonth && !day.isBooked,
                                                    'bg-red-100 border-red-300 cursor-not-allowed': day.isBooked
                                                }"
                                            >
                                                <span class="text-sm font-medium" x-text="day.day"></span>
                                                <span x-show="day.isBooked" class="text-[10px] font-semibold text-red-600 mt-0.5">Booked</span>
                                            </button>
                                        </div>
                                    </template>
                                </div>

                                <!-- Selected Date Info -->
                                <div x-show="startDate || endDate" class="mt-6 p-4 bg-white rounded-lg border border-gray-200">
                                    <p class="text-sm font-medium text-gray-700">Tanggal Terpilih:</p>
                                    <p class="text-lg font-semibold text-gray-900 mt-1">
                                        <span x-text="formatDate(startDate)"></span>
                                        <span x-show="endDate && startDate !== endDate"> - <span x-text="formatDate(endDate)"></span></span>
                                        <span x-show="startDate && endDate && startDate !== endDate" class="text-sm text-gray-600">
                                            (<span x-text="getDuration()"></span> hari)
                                        </span>
                                    </p>
                                </div>

                                <!-- Booked Dates Info -->
                                <div x-show="bookedDates.length > 0" class="mt-4">
                                    <p class="text-sm font-medium text-gray-700 mb-2">Peminjaman yang sedang berlangsung:</p>
                                    <div class="space-y-2">
                                        <template x-for="booking in bookedDates" :key="booking.id">
                                            <div class="flex items-center justify-between p-3 bg-red-50 border border-red-200 rounded-lg text-sm">
                                                <div>
                                                    <p class="font-medium text-gray-900" x-text="booking.user"></p>
                                                    <p class="text-gray-600" x-text="`${booking.start} - ${booking.end}`"></p>
                                                </div>
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800" x-text="booking.status"></span>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <!-- Hidden inputs for form submission -->
                                <input type="hidden" name="tanggal_mulai" :value="startDate" id="tanggal_mulai">
                                <input type="hidden" name="tanggal_selesai" :value="endDate" id="tanggal_selesai">
                            </div>

                            <!-- Tujuan -->
                            <div>
                                <label for="tujuan" class="block text-sm font-medium text-gray-700">
                                    Tujuan Perjalanan <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="tujuan" id="tujuan" 
                                    value="{{ old('tujuan') }}" required
                                    placeholder="Contoh: Jakarta - Bandung"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('tujuan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kebutuhan -->
                            <div>
                                <label for="kebutuhan" class="block text-sm font-medium text-gray-700">
                                    Detail Kebutuhan <span class="text-red-500">*</span>
                                </label>
                                <textarea name="kebutuhan" id="kebutuhan" rows="4" required
                                    placeholder="Jelaskan detail kebutuhan dan keperluan peminjaman kendaraan..."
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('kebutuhan') }}</textarea>
                                @error('kebutuhan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nomor HP PIC -->
                            <div>
                                <label for="nomor_hp_pic" class="block text-sm font-medium text-gray-700">
                                    Nomor HP Penanggung Jawab <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nomor_hp_pic" id="nomor_hp_pic" 
                                    value="{{ old('nomor_hp_pic', auth()->user()->phone) }}" required
                                    placeholder="08123456789"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <p class="mt-1 text-sm text-gray-500">Nomor yang dapat dihubungi selama masa peminjaman</p>
                                @error('nomor_hp_pic')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Info Box -->
                            <div class="rounded-md bg-blue-50 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-blue-700">
                                            <strong>Batas maksimal peminjaman: {{ $maxDays }} hari.</strong><br>
                                            Pengajuan akan diverifikasi oleh P3B dan memerlukan persetujuan dari Pengurus Barang sebelum kendaraan dapat digunakan.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end gap-x-4">
                            <a href="{{ route('peminjaman.index') }}" class="text-sm font-semibold leading-6 text-gray-900">Batal</a>
                            <button type="submit" x-bind:disabled="!startDate || !endDate" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
                                Submit Pengajuan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function peminjamanCalendar() {
            return {
                selectedKendaraan: '',
                currentMonth: new Date().getMonth(),
                currentYear: new Date().getFullYear(),
                startDate: null,
                endDate: null,
                bookedDates: [],
                calendarDays: [],
                maxDays: {{ $maxDays }},

                init() {
                    this.generateCalendar();
                },

                async loadBookings() {
                    if (!this.selectedKendaraan) return;
                    
                    try {
                        const response = await fetch(`/api/kendaraan/${this.selectedKendaraan}/bookings`);
                        const data = await response.json();
                        this.bookedDates = data.bookings || [];
                        this.generateCalendar();
                    } catch (error) {
                        console.error('Error loading bookings:', error);
                    }
                },

                generateCalendar() {
                    const firstDay = new Date(this.currentYear, this.currentMonth, 1);
                    const lastDay = new Date(this.currentYear, this.currentMonth + 1, 0);
                    const prevLastDay = new Date(this.currentYear, this.currentMonth, 0);
                    const firstDayIndex = firstDay.getDay();
                    const lastDayIndex = lastDay.getDay();
                    const nextDays = 7 - lastDayIndex - 1;

                    this.calendarDays = [];
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);

                    // Previous month days
                    for (let x = firstDayIndex; x > 0; x--) {
                        const date = new Date(this.currentYear, this.currentMonth - 1, prevLastDay.getDate() - x + 1);
                        this.calendarDays.push(this.createDayObject(date, false));
                    }

                    // Current month days
                    for (let i = 1; i <= lastDay.getDate(); i++) {
                        const date = new Date(this.currentYear, this.currentMonth, i);
                        this.calendarDays.push(this.createDayObject(date, true));
                    }

                    // Next month days
                    for (let j = 1; j <= nextDays; j++) {
                        const date = new Date(this.currentYear, this.currentMonth + 1, j);
                        this.calendarDays.push(this.createDayObject(date, false));
                    }
                },

                createDayObject(date, isCurrentMonth) {
                    const dateStr = this.formatDateToISO(date);
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);
                    const isPast = date < today;
                    const isBooked = this.isDateBooked(dateStr);
                    const isStart = this.startDate === dateStr;
                    const isEnd = this.endDate === dateStr;
                    const isInRange = this.isDateInRange(dateStr);

                    return {
                        day: date.getDate(),
                        date: dateStr,
                        isCurrentMonth,
                        isPast,
                        isBooked,
                        isSunday: date.getDay() === 0,
                        isStart,
                        isEnd,
                        isSelected: isStart || isEnd,
                        isInRange
                    };
                },

                isDateBooked(dateStr) {
                    return this.bookedDates.some(booking => {
                        return dateStr >= booking.start && dateStr <= booking.end;
                    });
                },

                isDateInRange(dateStr) {
                    if (!this.startDate || !this.endDate) return false;
                    return dateStr > this.startDate && dateStr < this.endDate;
                },

                selectDate(day) {
                    if (!day.isCurrentMonth || day.isPast || day.isBooked) return;

                    const dateStr = day.date;

                    if (!this.startDate || (this.startDate && this.endDate)) {
                        // Start new selection
                        this.startDate = dateStr;
                        this.endDate = null;
                    } else if (dateStr < this.startDate) {
                        // Selected date is before start date
                        this.endDate = this.startDate;
                        this.startDate = dateStr;
                    } else {
                        // Selected date is after start date
                        this.endDate = dateStr;
                        
                        // Check if duration exceeds max
                        if (this.getDurationInDays() > this.maxDays) {
                            alert(`Durasi peminjaman melebihi batas maksimal ${this.maxDays} hari!`);
                            this.endDate = null;
                            return;
                        }

                        // Check if any date in range is booked
                        if (this.hasBookedDateInRange()) {
                            alert('Terdapat tanggal yang sudah dibooking dalam rentang yang dipilih!');
                            this.startDate = null;
                            this.endDate = null;
                        }
                    }

                    this.generateCalendar();
                },

                hasBookedDateInRange() {
                    if (!this.startDate || !this.endDate) return false;
                    
                    const start = new Date(this.startDate);
                    const end = new Date(this.endDate);
                    
                    for (let d = new Date(start); d <= end; d.setDate(d.getDate() + 1)) {
                        if (this.isDateBooked(this.formatDateToISO(d))) {
                            return true;
                        }
                    }
                    return false;
                },

                getDurationInDays() {
                    if (!this.startDate || !this.endDate) return 0;
                    const start = new Date(this.startDate);
                    const end = new Date(this.endDate);
                    return Math.ceil((end - start) / (1000 * 60 * 60 * 24)) + 1;
                },

                getDuration() {
                    return this.getDurationInDays();
                },

                formatDateToISO(date) {
                    const d = new Date(date);
                    const year = d.getFullYear();
                    const month = String(d.getMonth() + 1).padStart(2, '0');
                    const day = String(d.getDate()).padStart(2, '0');
                    return `${year}-${month}-${day}`;
                },

                formatDate(dateStr) {
                    if (!dateStr) return '';
                    const d = new Date(dateStr);
                    return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                },

                getMonthYearText() {
                    const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                        'July', 'August', 'September', 'October', 'November', 'December'];
                    return `${monthNames[this.currentMonth]} ${this.currentYear}`;
                },

                prevMonth() {
                    if (this.currentMonth === 0) {
                        this.currentMonth = 11;
                        this.currentYear--;
                    } else {
                        this.currentMonth--;
                    }
                    this.generateCalendar();
                },

                nextMonth() {
                    if (this.currentMonth === 11) {
                        this.currentMonth = 0;
                        this.currentYear++;
                    } else {
                        this.currentMonth++;
                    }
                    this.generateCalendar();
                }
            }
        }
    </script>
</x-app-layout>
