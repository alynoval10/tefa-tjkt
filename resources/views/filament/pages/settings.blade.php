<x-filament-panels::page>

    <form wire:submit="save">

        <div style="
            display:flex;
            flex-direction:column;
            gap:20px;
        ">


            {{-- =====================================================
                 IDENTITAS
            ====================================================== --}}

            <div style="
                border:1px solid #27272a;
                border-radius:12px;
                background:#18181b;
                padding:20px;
            ">

                <div style="
                    font-size:15px;
                    font-weight:600;
                    color:#fff;
                    margin-bottom:18px;
                ">
                    Identitas
                </div>


                <div style="
                    display:grid;
                    grid-template-columns:1fr 1fr;
                    gap:16px;
                ">


                    {{-- NAMA SEKOLAH --}}

                    <div>

                        <label style="
                            display:block;
                            margin-bottom:6px;
                            color:#fff;
                            font-size:13px;
                            font-weight:600;
                        ">
                            Nama Sekolah
                        </label>

                        <input
                            type="text"
                            wire:model="school_name"
                            style="
                                width:100%;
                                border:1px solid #3f3f46;
                                border-radius:8px;
                                background:#09090b;
                                color:#fff;
                                padding:9px 11px;
                            "
                        >

                    </div>


                    {{-- NAMA TEFA --}}

                    <div>

                        <label style="
                            display:block;
                            margin-bottom:6px;
                            color:#fff;
                            font-size:13px;
                            font-weight:600;
                        ">
                            Nama TEFA
                        </label>

                        <input
                            type="text"
                            wire:model="tefa_name"
                            style="
                                width:100%;
                                border:1px solid #3f3f46;
                                border-radius:8px;
                                background:#09090b;
                                color:#fff;
                                padding:9px 11px;
                            "
                        >

                    </div>


                    {{-- JURUSAN --}}

                    <div style="
                        grid-column:1 / -1;
                    ">

                        <label style="
                            display:block;
                            margin-bottom:6px;
                            color:#fff;
                            font-size:13px;
                            font-weight:600;
                        ">
                            Program / Jurusan
                        </label>

                        <input
                            type="text"
                            wire:model="department_name"
                            style="
                                width:100%;
                                border:1px solid #3f3f46;
                                border-radius:8px;
                                background:#09090b;
                                color:#fff;
                                padding:9px 11px;
                            "
                        >

                    </div>

                </div>

            </div>



            {{-- =====================================================
                 INFORMASI KONTAK
            ====================================================== --}}

            <div style="
                border:1px solid #27272a;
                border-radius:12px;
                background:#18181b;
                padding:20px;
            ">

                <div style="
                    font-size:15px;
                    font-weight:600;
                    color:#fff;
                    margin-bottom:18px;
                ">
                    Informasi Kontak
                </div>


                <div style="
                    display:grid;
                    grid-template-columns:1fr 1fr;
                    gap:16px;
                ">


                    {{-- ALAMAT --}}

                    <div style="
                        grid-column:1 / -1;
                    ">

                        <label style="
                            display:block;
                            margin-bottom:6px;
                            color:#fff;
                            font-size:13px;
                            font-weight:600;
                        ">
                            Alamat
                        </label>

                        <textarea
                            wire:model="address"
                            rows="3"
                            style="
                                width:100%;
                                border:1px solid #3f3f46;
                                border-radius:8px;
                                background:#09090b;
                                color:#fff;
                                padding:9px 11px;
                                resize:vertical;
                            "
                        ></textarea>

                    </div>


                    {{-- TELEPON --}}

                    <div>

                        <label style="
                            display:block;
                            margin-bottom:6px;
                            color:#fff;
                            font-size:13px;
                            font-weight:600;
                        ">
                            Telepon
                        </label>

                        <input
                            type="text"
                            wire:model="phone"
                            style="
                                width:100%;
                                border:1px solid #3f3f46;
                                border-radius:8px;
                                background:#09090b;
                                color:#fff;
                                padding:9px 11px;
                            "
                        >

                    </div>


                    {{-- EMAIL --}}

                    <div>

                        <label style="
                            display:block;
                            margin-bottom:6px;
                            color:#fff;
                            font-size:13px;
                            font-weight:600;
                        ">
                            Email
                        </label>

                        <input
                            type="email"
                            wire:model="email"
                            style="
                                width:100%;
                                border:1px solid #3f3f46;
                                border-radius:8px;
                                background:#09090b;
                                color:#fff;
                                padding:9px 11px;
                            "
                        >

                    </div>


                    {{-- WEBSITE --}}

                    <div style="
                        grid-column:1 / -1;
                    ">

                        <label style="
                            display:block;
                            margin-bottom:6px;
                            color:#fff;
                            font-size:13px;
                            font-weight:600;
                        ">
                            Website
                        </label>

                        <input
                            type="text"
                            wire:model="website"
                            placeholder="https://..."
                            style="
                                width:100%;
                                border:1px solid #3f3f46;
                                border-radius:8px;
                                background:#09090b;
                                color:#fff;
                                padding:9px 11px;
                            "
                        >

                    </div>

                </div>

            </div>



            {{-- =====================================================
                 PENANGGUNG JAWAB
            ====================================================== --}}

            <div style="
                border:1px solid #27272a;
                border-radius:12px;
                background:#18181b;
                padding:20px;
            ">

                <div style="
                    font-size:15px;
                    font-weight:600;
                    color:#fff;
                    margin-bottom:18px;
                ">
                    Penanggung Jawab
                </div>


                <div style="
                    display:grid;
                    grid-template-columns:1fr 1fr;
                    gap:16px;
                ">


                    {{-- KEPALA PROGRAM --}}

                    <div>

                        <label style="
                            display:block;
                            margin-bottom:6px;
                            color:#fff;
                            font-size:13px;
                            font-weight:600;
                        ">
                            Kepala Program
                        </label>

                        <select
                            wire:model="head_program_id"
                            style="
                                width:100%;
                                border:1px solid #3f3f46;
                                border-radius:8px;
                                background:#09090b;
                                color:#fff;
                                padding:9px 11px;
                            "
                        >

                            <option value="">
                                -- Pilih --
                            </option>

                            @foreach(
                                \App\Models\User::orderBy('name')->get()
                                as $user
                            )

                                <option value="{{ $user->id }}">
                                    {{ $user->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- BENDAHARA --}}

                    <div>

                        <label style="
                            display:block;
                            margin-bottom:6px;
                            color:#fff;
                            font-size:13px;
                            font-weight:600;
                        ">
                            Bendahara
                        </label>

                        <select
                            wire:model="treasurer_id"
                            style="
                                width:100%;
                                border:1px solid #3f3f46;
                                border-radius:8px;
                                background:#09090b;
                                color:#fff;
                                padding:9px 11px;
                            "
                        >

                            <option value="">
                                -- Pilih --
                            </option>

                            @foreach(
                                \App\Models\User::orderBy('name')->get()
                                as $user
                            )

                                <option value="{{ $user->id }}">
                                    {{ $user->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

            </div>



            {{-- =====================================================
                 LOGO
            ====================================================== --}}

            <div style="
                border:1px solid #27272a;
                border-radius:12px;
                background:#18181b;
                padding:20px;
            ">

                <div style="
                    font-size:15px;
                    font-weight:600;
                    color:#fff;
                    margin-bottom:18px;
                ">
                    Logo
                </div>


                <div style="
                    display:grid;
                    grid-template-columns:1fr 1fr;
                    gap:20px;
                ">


                    {{-- LOGO SEKOLAH --}}

                    <div>

                        <label style="
                            display:block;
                            margin-bottom:8px;
                            color:#fff;
                            font-size:13px;
                            font-weight:600;
                        ">
                            Logo Sekolah
                        </label>


                        <input
                            type="file"
                            wire:model="school_logo"
                            accept="image/png,image/jpeg,image/webp"
                            style="
                                width:100%;
                                color:#a1a1aa;
                                font-size:13px;
                            "
                        >


                        <div style="
                            margin-top:8px;
                            font-size:11px;
                            color:#71717a;
                        ">
                            PNG, JPG atau WEBP. Maksimal 2 MB.
                        </div>


                        {{-- PREVIEW UPLOAD BARU --}}

                        @if(
                            $school_logo instanceof
                            \Livewire\Features\SupportFileUploads\TemporaryUploadedFile
                        )

                            <div style="
                                margin-top:12px;
                            ">

                                <img
                                    src="{{ $school_logo->temporaryUrl() }}"
                                    style="
                                        width:90px;
                                        height:90px;
                                        object-fit:contain;
                                        border:1px solid #3f3f46;
                                        border-radius:8px;
                                        background:#09090b;
                                        padding:8px;
                                    "
                                >

                            </div>


                        {{-- PREVIEW LOGO LAMA --}}

                        @elseif($school_logo)

                            <div style="
                                margin-top:12px;
                            ">

                                <img
                                    src="{{ asset('storage/' . $school_logo) }}"
                                    style="
                                        width:90px;
                                        height:90px;
                                        object-fit:contain;
                                        border:1px solid #3f3f46;
                                        border-radius:8px;
                                        background:#09090b;
                                        padding:8px;
                                    "
                                >

                            </div>

                        @endif

                    </div>



                    {{-- LOGO TEFA --}}

                    <div>

                        <label style="
                            display:block;
                            margin-bottom:8px;
                            color:#fff;
                            font-size:13px;
                            font-weight:600;
                        ">
                            Logo TEFA
                        </label>


                        <input
                            type="file"
                            wire:model="tefa_logo"
                            accept="image/png,image/jpeg,image/webp"
                            style="
                                width:100%;
                                color:#a1a1aa;
                                font-size:13px;
                            "
                        >


                        <div style="
                            margin-top:8px;
                            font-size:11px;
                            color:#71717a;
                        ">
                            PNG, JPG atau WEBP. Maksimal 2 MB.
                        </div>


                        {{-- PREVIEW UPLOAD BARU --}}

                        @if(
                            $tefa_logo instanceof
                            \Livewire\Features\SupportFileUploads\TemporaryUploadedFile
                        )

                            <div style="
                                margin-top:12px;
                            ">

                                <img
                                    src="{{ $tefa_logo->temporaryUrl() }}"
                                    style="
                                        width:90px;
                                        height:90px;
                                        object-fit:contain;
                                        border:1px solid #3f3f46;
                                        border-radius:8px;
                                        background:#09090b;
                                        padding:8px;
                                    "
                                >

                            </div>


                        {{-- PREVIEW LOGO LAMA --}}

                        @elseif($tefa_logo)

                            <div style="
                                margin-top:12px;
                            ">

                                <img
                                    src="{{ asset('storage/' . $tefa_logo) }}"
                                    style="
                                        width:90px;
                                        height:90px;
                                        object-fit:contain;
                                        border:1px solid #3f3f46;
                                        border-radius:8px;
                                        background:#09090b;
                                        padding:8px;
                                    "
                                >

                            </div>

                        @endif

                    </div>

                </div>

            </div>



            {{-- =====================================================
                 TOMBOL SIMPAN
            ====================================================== --}}

            <div style="
                display:flex;
                justify-content:flex-end;
            ">

                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    style="
                        padding:10px 18px;
                        border:0;
                        border-radius:8px;
                        background:#2563eb;
                        color:#fff;
                        font-weight:600;
                        cursor:pointer;
                    "
                >

                    <span wire:loading.remove>
                        Simpan Pengaturan
                    </span>

                    <span wire:loading>
                        Menyimpan...
                    </span>

                </button>

            </div>

        </div>

    </form>

</x-filament-panels::page>