<x-filament-panels::page>
    <form method="GET" class="fi-section rounded-xl border p-4">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
            <div>
                <label class="block text-sm font-medium">Veikals</label>
                <select name="shop_id" class="fi-input mt-1 w-full rounded-lg border px-3 py-2">
                    <option value="">Visi veikali</option>
                    @foreach ($shops as $id => $name)
                        <option value="{{ $id }}" @selected((string) $id === $filters['shop_id'])>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium">No datuma</label>
                <input type="date" name="from" value="{{ $filters['from'] }}" class="fi-input mt-1 w-full rounded-lg border px-3 py-2" />
            </div>
            <div>
                <label class="block text-sm font-medium">Līdz datumam</label>
                <input type="date" name="to" value="{{ $filters['to'] }}" class="fi-input mt-1 w-full rounded-lg border px-3 py-2" />
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="fi-btn rounded-lg bg-primary-600 px-4 py-2 font-semibold text-white">
                    Filtrēt
                </button>
                <a href="{{ \App\Filament\Pages\Analytics::getUrl() }}" class="fi-btn rounded-lg border px-4 py-2 font-semibold">
                    Notīrīt
                </a>
            </div>
        </div>
    </form>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-5">
        <div class="fi-section rounded-xl border p-4">
            <p class="text-sm text-gray-500">Veikali kopā</p>
            <p class="text-2xl font-bold">{{ $metrics['shops'] }}</p>
        </div>
        <div class="fi-section rounded-xl border p-4">
            <p class="text-sm text-gray-500">Aktīvie veikali</p>
            <p class="text-2xl font-bold">{{ $metrics['activeShops'] }}</p>
        </div>
        <div class="fi-section rounded-xl border p-4">
            <p class="text-sm text-gray-500">Piedāvājumi</p>
            <p class="text-2xl font-bold">{{ $metrics['offers'] }}</p>
        </div>
        <div class="fi-section rounded-xl border p-4">
            <p class="text-sm text-gray-500">Importi</p>
            <p class="text-2xl font-bold">{{ $metrics['imports'] }}</p>
        </div>
        <div class="fi-section rounded-xl border p-4">
            <p class="text-sm text-gray-500">Vidējā cena</p>
            <p class="text-2xl font-bold">{{ number_format((float) ($metrics['avgPrice'] ?? 0), 2) }} EUR</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
        <div class="fi-section rounded-xl border p-4">
            <h3 class="mb-3 text-base font-semibold">Top veikali pēc piedāvājumiem</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Veikals</th>
                            <th class="py-2">Piedāvājumi</th>
                            <th class="py-2">Vidējā cena</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($shopTotals as $row)
                            <tr class="border-b">
                                <td class="py-2">{{ $row->shop?->name ?? '-' }}</td>
                                <td class="py-2">{{ $row->offers_count }}</td>
                                <td class="py-2">{{ number_format((float) $row->avg_price, 2) }} EUR</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-4 text-gray-500">Nav datu izvēlētajiem filtriem.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="fi-section rounded-xl border p-4">
            <h3 class="mb-3 text-base font-semibold">Pēdējie importi</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Veikals</th>
                            <th class="py-2">Faila tips</th>
                            <th class="py-2">Importēts</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($latestImports as $row)
                            <tr class="border-b">
                                <td class="py-2">{{ $row->shop?->name ?? '-' }}</td>
                                <td class="py-2">{{ $row->file_type }}</td>
                                <td class="py-2">{{ optional($row->imported_at)->format('d.m.Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-4 text-gray-500">Nav importu ierakstu.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-filament-panels::page>
