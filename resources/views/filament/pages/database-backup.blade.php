<x-filament-panels::page>

    <div style="display: flex; flex-direction: column; gap: 24px;">

        {{-- HEADER INFO --}}
        <div style="
            border: 1px solid #27272a;
            border-radius: 12px;
            background: #18181b;
            padding: 24px;
        ">

            <div style="
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 20px;
            ">

                <div>

                    <div style="
                        font-size: 16px;
                        font-weight: 600;
                        color: #ffffff;
                    ">
                        Backup Database
                    </div>

                    <div style="
                        margin-top: 6px;
                        font-size: 13px;
                        color: #a1a1aa;
                    ">
                        Buat salinan database aplikasi dalam format SQL.
                    </div>

                </div>

                <div style="
                    padding: 8px 12px;
                    border-radius: 8px;
                    background: rgba(59, 130, 246, .12);
                    color: #60a5fa;
                    font-size: 12px;
                    font-weight: 600;
                ">
                    MySQL
                </div>

            </div>


            {{-- WARNING --}}
            <div style="
                margin-top: 20px;
                border: 1px solid rgba(245, 158, 11, .25);
                border-radius: 8px;
                background: rgba(245, 158, 11, .08);
                padding: 14px 16px;
                color: #fbbf24;
                font-size: 13px;
                line-height: 1.5;
            ">

                <strong>Perhatian</strong>

                <div style="
                    margin-top: 3px;
                    color: #d4d4d8;
                ">
                    File backup berisi seluruh data aplikasi.
                    Simpan file backup di tempat yang aman.
                </div>

            </div>

        </div>


        {{-- DAFTAR BACKUP --}}
        <div style="
            overflow: hidden;
            border: 1px solid #27272a;
            border-radius: 12px;
            background: #18181b;
        ">

            <div style="
                padding: 18px 20px;
                border-bottom: 1px solid #27272a;
            ">

                <div style="
                    font-size: 15px;
                    font-weight: 600;
                    color: #ffffff;
                ">
                    Daftar Backup
                </div>

                <div style="
                    margin-top: 4px;
                    font-size: 12px;
                    color: #71717a;
                ">
                    Backup database yang tersimpan di server.
                </div>

            </div>


            @php
                $backups = $this->getBackups();
            @endphp


            @if(count($backups))

                <div>

                    @foreach($backups as $backup)

                        <div style="
                            display: flex;
                            align-items: center;
                            justify-content: space-between;
                            gap: 20px;
                            padding: 16px 20px;
                            border-bottom: 1px solid #27272a;
                        ">

                            {{-- FILE INFO --}}
                            <div style="
                                min-width: 0;
                                display: flex;
                                align-items: center;
                                gap: 14px;
                            ">

                                {{-- ICON --}}
                                <div style="
                                    width: 40px;
                                    height: 40px;
                                    flex-shrink: 0;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    border-radius: 8px;
                                    background: rgba(59, 130, 246, .12);
                                    color: #60a5fa;
                                    font-size: 18px;
                                ">
                                    ↓
                                </div>


                                <div style="min-width: 0;">

                                    <div style="
                                        overflow: hidden;
                                        text-overflow: ellipsis;
                                        white-space: nowrap;
                                        font-size: 13px;
                                        font-weight: 600;
                                        color: #ffffff;
                                    ">
                                        {{ $backup['name'] }}
                                    </div>

                                    <div style="
                                        margin-top: 4px;
                                        font-size: 12px;
                                        color: #71717a;
                                    ">
                                        {{ $backup['created_at'] }}
                                        <span style="margin: 0 5px;">•</span>
                                        {{ $backup['size'] }}
                                    </div>

                                </div>

                            </div>


                            {{-- DOWNLOAD --}}
                           <div style="
    display: flex;
    align-items: center;
    gap: 8px;
">

    <a
        href="{{ route('database-backup.download', ['filename' => $backup['name']]) }}"
        style="
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 13px;
            border: 1px solid #3f3f46;
            border-radius: 7px;
            background: #27272a;
            color: #ffffff;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
        "
    >
        ↓
        Download
    </a>


    <button
        type="button"
        wire:click="deleteBackup('{{ $backup['name'] }}')"
        onclick="return confirm('Yakin ingin menghapus backup {{ $backup['name'] }}?')"
        style="
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 13px;
            border: 1px solid rgba(239,68,68,.30);
            border-radius: 7px;
            background: rgba(239,68,68,.08);
            color: #f87171;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
        "
    >
        🗑
        Hapus
    </button>

</div>

                        </div>

                    @endforeach

                </div>

            @else

                <div style="
                    padding: 50px 20px;
                    text-align: center;
                ">

                    <div style="
                        font-size: 28px;
                        color: #52525b;
                    ">
                        ↓
                    </div>

                    <div style="
                        margin-top: 10px;
                        font-size: 13px;
                        color: #a1a1aa;
                    ">
                        Belum ada backup database.
                    </div>

                </div>

            @endif

        </div>

    </div>

</x-filament-panels::page>