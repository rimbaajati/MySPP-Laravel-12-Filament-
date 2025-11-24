<x-filament-panels::page>
    <x-filament::section>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Kolom Kiri -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama -->
                <div>
                    <label class="block text-gray-400 font-medium mb-1">Nama Lengkap</label>
                    <p class="text-gray-900 font-semibold">{{ $user->name }}</p>
                </div>
                <!-- Nomor Telepon -->
                <div>
                    <label class="block text-gray-400 font-medium mb-1">Nomor Telepon</label>
                    <p class="text-gray-900 font-semibold">{{ $user->phone }}</p>
                </div>
                <!-- Email -->
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-gray-400 font-medium mb-1">Email</label>
                    <p class="text-gray-900 font-semibold">{{ $user->email }}</p>
                </div>
            </div>
        </div>
        <!-- Formulir untuk menampilkan Scan Ijazah -->
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-gray-400 font-medium mb-1">Scan Ijazah</label>
                <img 
                    src="{{ $user->scanijazah ? asset('storage/' . $user->scanijazah) : asset('image/default-file.png') }}"
                    alt="Scan Ijazah"
                    class="w-32 h-auto object-cover rounded-md border cursor-pointer"
                    x-on:click="
                        $dispatch('open-modal', { 
                            id: 'image-modal', 
                            image: '{{ $user->scanijazah ? asset('storage/' . $user->scanijazah) : asset('image/default-file.png') }}' 
                        })" />
            </div>
        </div>

    </x-filament::section>
</x-filament-panels::page>

