@php
    $properties = $activity->properties?->toArray() ?? [];

    $attributes = $properties['attributes'] ?? [];
    $old = $properties['old'] ?? [];

    $data = !empty($attributes) ? $attributes : $old;

    $category = null;

    if (!empty($data['category_id'])) {
        $category = \App\Models\Category::find($data['category_id']);
    }

    $eventLabel = match ($activity->event) {
        'created' => 'Dibuat',
        'updated' => 'Diubah',
        'deleted' => 'Dihapus',
        default => ucfirst($activity->event ?? '-'),
    };

    $tanggal = '-';

    if (!empty($data['tanggal'])) {
        try {
            $tanggal = \Carbon\Carbon::parse($data['tanggal'])
                ->locale('id')
                ->translatedFormat('d F Y');
        } catch (\Throwable $e) {
            $tanggal = $data['tanggal'];
        }
    }

    $nominal = $data['nominal'] ?? null;
@endphp


<div style="font-size: 14px; line-height: 1.5;">

    {{-- INFORMASI AKTIVITAS --}}
    <div style="margin-bottom: 24px;">

        <div style="
            font-size: 12px;
            font-weight: 600;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: .05em;
            margin-bottom: 10px;
        ">
            Informasi Aktivitas
        </div>


        <div style="
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        ">

            {{-- USER --}}
            <div style="
                border: 1px solid #374151;
                border-radius: 8px;
                padding: 12px;
            ">
                <div style="font-size: 12px; color: #9ca3af;">
                    User
                </div>

                <div style="margin-top: 3px; font-weight: 600;">
                    {{ $activity->causer?->name ?? '-' }}
                </div>
            </div>


            {{-- WAKTU --}}
            <div style="
                border: 1px solid #374151;
                border-radius: 8px;
                padding: 12px;
            ">
                <div style="font-size: 12px; color: #9ca3af;">
                    Waktu
                </div>

                <div style="margin-top: 3px; font-weight: 600;">
                    {{ $activity->created_at?->format('d M Y, H:i') }}
                </div>
            </div>


            {{-- AKSI --}}
            <div style="
                border: 1px solid #374151;
                border-radius: 8px;
                padding: 12px;
            ">
                <div style="font-size: 12px; color: #9ca3af;">
                    Aksi
                </div>

                <div style="margin-top: 5px;">

                    @if($activity->event === 'created')

                        <span style="
                            display: inline-block;
                            padding: 3px 8px;
                            border-radius: 6px;
                            background: rgba(34,197,94,.12);
                            color: #22c55e;
                            font-size: 12px;
                            font-weight: 600;
                        ">
                            Dibuat
                        </span>

                    @elseif($activity->event === 'updated')

                        <span style="
                            display: inline-block;
                            padding: 3px 8px;
                            border-radius: 6px;
                            background: rgba(234,179,8,.12);
                            color: #eab308;
                            font-size: 12px;
                            font-weight: 600;
                        ">
                            Diubah
                        </span>

                    @elseif($activity->event === 'deleted')

                        <span style="
                            display: inline-block;
                            padding: 3px 8px;
                            border-radius: 6px;
                            background: rgba(239,68,68,.12);
                            color: #ef4444;
                            font-size: 12px;
                            font-weight: 600;
                        ">
                            Dihapus
                        </span>

                    @else

                        <span>
                            {{ $eventLabel }}
                        </span>

                    @endif

                </div>
            </div>


            {{-- DATA --}}
            <div style="
                border: 1px solid #374151;
                border-radius: 8px;
                padding: 12px;
            ">
                <div style="font-size: 12px; color: #9ca3af;">
                    Data
                </div>

                <div style="margin-top: 3px; font-weight: 600;">
                    {{ $activity->subject_type ? class_basename($activity->subject_type) : '-' }}
                </div>
            </div>

        </div>

    </div>


    {{-- DATA TRANSAKSI --}}
    @if($activity->log_name === 'kas')

        <div style="margin-bottom: 24px;">

            <div style="
                font-size: 12px;
                font-weight: 600;
                color: #9ca3af;
                text-transform: uppercase;
                letter-spacing: .05em;
                margin-bottom: 10px;
            ">
                Data Transaksi
            </div>


            <div style="
                border: 1px solid #374151;
                border-radius: 8px;
                overflow: hidden;
            ">

                {{-- NO BUKTI --}}
                <div style="
                    display: grid;
                    grid-template-columns: 130px 1fr;
                    padding: 10px 14px;
                    border-bottom: 1px solid #374151;
                ">

                    <div style="color: #9ca3af;">
                        No. Bukti
                    </div>

                    <div style="font-weight: 600;">
                        {{ $data['no_bukti'] ?? '-' }}
                    </div>

                </div>


                {{-- TANGGAL --}}
                <div style="
                    display: grid;
                    grid-template-columns: 130px 1fr;
                    padding: 10px 14px;
                    border-bottom: 1px solid #374151;
                ">

                    <div style="color: #9ca3af;">
                        Tanggal
                    </div>

                    <div style="font-weight: 600;">
                        {{ $tanggal }}
                    </div>

                </div>


                {{-- KATEGORI --}}
                <div style="
                    display: grid;
                    grid-template-columns: 130px 1fr;
                    padding: 10px 14px;
                    border-bottom: 1px solid #374151;
                ">

                    <div style="color: #9ca3af;">
                        Kategori
                    </div>

                    <div style="font-weight: 600;">
                        {{ $category?->name ?? '-' }}
                    </div>

                </div>


                {{-- NOMINAL --}}
                <div style="
                    display: grid;
                    grid-template-columns: 130px 1fr;
                    padding: 10px 14px;
                    border-bottom: 1px solid #374151;
                ">

                    <div style="color: #9ca3af;">
                        Nominal
                    </div>

                    <div style="font-weight: 700;">
                        @if($nominal !== null)
                            Rp {{ number_format((float) $nominal, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </div>

                </div>


                {{-- KETERANGAN --}}
                <div style="
                    display: grid;
                    grid-template-columns: 130px 1fr;
                    padding: 10px 14px;
                ">

                    <div style="color: #9ca3af;">
                        Keterangan
                    </div>

                    <div style="font-weight: 600;">
                        {{ $data['keterangan'] ?? '-' }}
                    </div>

                </div>

            </div>

        </div>

    @endif


    {{-- PERUBAHAN DATA --}}
    @if($activity->event === 'updated' && !empty($old) && !empty($attributes))

        <div>

            <div style="
                font-size: 12px;
                font-weight: 600;
                color: #9ca3af;
                text-transform: uppercase;
                letter-spacing: .05em;
                margin-bottom: 10px;
            ">
                Perubahan Data
            </div>


            <div style="
                border: 1px solid #374151;
                border-radius: 8px;
                overflow: hidden;
            ">

                @foreach($attributes as $field => $newValue)

                    @php
                        $oldValue = $old[$field] ?? null;
                    @endphp

                    @if($oldValue != $newValue)

                        <div style="
                            display: grid;
                            grid-template-columns: 130px 1fr;
                            padding: 10px 14px;
                            border-bottom: 1px solid #374151;
                        ">

                            <div style="color: #9ca3af;">
                                {{ ucwords(str_replace('_', ' ', $field)) }}
                            </div>

                            <div>

                                <span style="color: #ef4444;">
                                    {{ $oldValue ?? '-' }}
                                </span>

                                <span style="color: #6b7280; margin: 0 8px;">
                                    →
                                </span>

                                <span style="
                                    color: #22c55e;
                                    font-weight: 600;
                                ">
                                    {{ $newValue ?? '-' }}
                                </span>

                            </div>

                        </div>

                    @endif

                @endforeach

            </div>

        </div>

    @endif

</div>