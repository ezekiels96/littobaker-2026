<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#10233f">
    <title>WVAC Attendance</title>
    <style>
        :root {
            --navy: #10233f;
            --teal: #2f7d6b;
            --teal-soft: #e6f4f0;
            --ink: #1b1b18;
            --muted: #6b7280;
            --line: #e6e8ec;
            --bg: #f4f6f9;
            --present: #16a34a;
            --present-bg: #ecfdf3;
            --english: #2563eb;   /* blue  */
            --chinese: #9b1c1c;   /* brand red */
            --accent: var(--english);
        }
        body.svc-chinese { --accent: var(--chinese); }
        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
        html, body { margin: 0; padding: 0; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'PingFang SC',
                         'Hiragino Sans GB', 'Microsoft YaHei', 'Noto Sans CJK SC', sans-serif;
            background: var(--bg);
            color: var(--ink);
            -webkit-font-smoothing: antialiased;
            padding-bottom: 120px;
        }

        /* ---------- Logo bar ---------- */
        .logobar {
            background: #fff; text-align: center;
            padding: 10px 16px calc(10px);
            padding-top: max(10px, env(safe-area-inset-top));
            border-bottom: 1px solid var(--line);
        }
        .logobar img { height: 40px; width: auto; max-width: 100%; display: inline-block; }

        /* ---------- Header ---------- */
        .topbar {
            position: sticky; top: 0; z-index: 20;
            background: var(--navy);
            color: #fff;
            padding: 14px 16px calc(14px + env(safe-area-inset-top)) 16px;
            padding-top: max(14px, env(safe-area-inset-top));
            box-shadow: 0 2px 14px rgba(0,0,0,.12);
        }
        .brand { display: flex; align-items: center; justify-content: space-between; gap: 10px; }
        .brand h1 { font-size: 17px; margin: 0; font-weight: 800; letter-spacing: .01em; }
        .brand .sub { font-size: 11px; opacity: .7; margin-top: 1px; }
        .date-select {
            appearance: none; -webkit-appearance: none;
            background: rgba(255,255,255,.12) url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='3'><path d='M6 9l6 6 6-6'/></svg>") no-repeat right 12px center;
            color: #fff; border: 1px solid rgba(255,255,255,.2);
            border-radius: 12px; padding: 9px 34px 9px 12px;
            font-size: 14px; font-weight: 600; max-width: 62vw;
        }
        .date-select option { color: #000; }

        /* ---------- Service toggle ---------- */
        .seg {
            display: flex; background: rgba(255,255,255,.12);
            border-radius: 12px; padding: 4px; margin-top: 12px; gap: 4px;
        }
        .seg button {
            flex: 1; border: 0; background: transparent; color: rgba(255,255,255,.75);
            font-size: 14px; font-weight: 700; padding: 9px 6px; border-radius: 9px;
            cursor: pointer; transition: background .15s, color .15s;
        }
        #seg-english.active { background: var(--english); color: #fff; }
        #seg-chinese.active { background: var(--chinese); color: #fff; }

        /* ---------- Count card ---------- */
        .countcard {
            margin-top: 12px; background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.14);
            border-left: 5px solid var(--accent);
            border-radius: 14px; padding: 12px 16px;
            display: flex; align-items: baseline; gap: 10px;
            transition: border-color .15s;
        }
        .countcard .num { font-size: 34px; font-weight: 800; line-height: 1; }
        .countcard .cap { font-size: 12px; text-transform: uppercase; letter-spacing: .1em; opacity: .8; }
        .countcard .trend { margin-left: auto; text-align: right; font-size: 11px; opacity: .8; line-height: 1.4; }

        /* ---------- Panels ---------- */
        .panel { display: none; padding: 14px 14px 0; }
        .panel.active { display: block; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }

        .tile {
            display: flex; flex-direction: column; justify-content: center;
            gap: 2px; text-align: left;
            min-height: 66px; padding: 12px 14px;
            background: #fff; border: 1.5px solid var(--line);
            border-radius: 16px; cursor: pointer; position: relative;
            transition: transform .08s, border-color .12s, background .12s;
            font-family: inherit;
            -webkit-user-select: none; user-select: none; -webkit-touch-callout: none;
        }
        .tile:active { transform: scale(.97); }
        .tile .nm { font-size: 16px; font-weight: 700; color: var(--ink); line-height: 1.2; }
        .tile .nm2 { font-size: 13px; color: var(--muted); line-height: 1.2; }
        .tile .tick {
            position: absolute; top: 10px; right: 10px;
            width: 22px; height: 22px; border-radius: 50%;
            border: 2px solid var(--line); background: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; color: transparent; font-weight: 900;
        }
        .tile[data-present="1"] {
            background: var(--present-bg); border-color: var(--present);
        }
        .tile[data-present="1"] .tick {
            background: var(--present); border-color: var(--present); color: #fff;
        }
        .tile[data-present="1"] .nm { color: #14532d; }

        .empty { grid-column: 1 / -1; text-align: center; color: var(--muted); padding: 26px 10px; font-size: 14px; }

        /* ---------- Add person buttons ---------- */
        .btn-save { background: var(--teal); color: #fff; }
        .btn-cancel { background: #eef0f3; color: var(--ink); }

        /* ---------- Submit bar ---------- */
        .submitbar {
            position: fixed; left: 0; right: 0; bottom: 0; z-index: 20;
            background: rgba(255,255,255,.96); backdrop-filter: blur(8px);
            border-top: 1px solid var(--line);
            padding: 12px 14px calc(12px + env(safe-area-inset-bottom)) 14px;
            display: flex; gap: 10px;
        }
        .submitbar button { border: 0; border-radius: 14px; font-weight: 800; font-size: 15px; cursor: pointer; font-family: inherit; }
        .btn-submit { flex: 1; background: var(--navy); color: #fff; padding: 15px; }
        .btn-submit:active { transform: scale(.99); }
        .btn-both { background: var(--teal-soft); color: var(--teal); padding: 15px 16px; }
        .btn-submit:disabled, .btn-both:disabled { opacity: .55; }

        /* ---------- Toast ---------- */
        .toast {
            position: fixed; left: 50%; bottom: 96px; transform: translateX(-50%) translateY(20px);
            background: var(--navy); color: #fff; padding: 12px 20px; border-radius: 999px;
            font-size: 14px; font-weight: 600; opacity: 0; pointer-events: none;
            transition: opacity .2s, transform .2s; z-index: 40; max-width: 88vw; text-align: center;
        }
        .toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }
        .toast.err { background: #b91c1c; }

        /* ---------- Tool row (search + add) ---------- */
        .toolrow { display: flex; gap: 8px; margin-top: 10px; }
        .tool-btn {
            flex: 1; display: flex; align-items: center; justify-content: center; gap: 6px;
            background: rgba(255,255,255,.12); color: #fff;
            border: 1px solid rgba(255,255,255,.2); border-radius: 12px;
            padding: 9px 10px; font-size: 14px; font-weight: 700; cursor: pointer;
            font-family: inherit; transition: background .15s;
        }
        .tool-btn:active { transform: scale(.98); }
        .tool-btn.active { background: rgba(255,255,255,.28); }

        /* ---------- Search bar ---------- */
        .searchwrap { display: none; margin-top: 8px; position: relative; }
        .searchwrap.open { display: block; }
        .searchwrap input {
            width: 100%; padding: 11px 38px 11px 14px; font-size: 16px; font-family: inherit;
            border: 1px solid rgba(255,255,255,.2); border-radius: 12px; outline: none;
            background: #fff; color: var(--ink);
        }
        .search-clear {
            position: absolute; top: 50%; right: 8px; transform: translateY(-50%);
            width: 26px; height: 26px; border: 0; border-radius: 50%;
            background: #eef0f3; color: var(--muted); font-size: 15px; font-weight: 700;
            cursor: pointer; line-height: 1; display: none;
        }
        .searchwrap.has-text .search-clear { display: flex; align-items: center; justify-content: center; }

        .tile.hide { display: none; }

        /* ---------- Empty / no-match states ---------- */
        .empty-hint, .nomatch { grid-column: 1 / -1; text-align: center; }
        .empty-hint { color: var(--muted); padding: 30px 12px; font-size: 14px; line-height: 1.5; }
        .nomatch {
            display: none; min-height: 54px; margin-top: 4px;
            border: 2px dashed #c7cdd6; background: #fff; color: var(--navy);
            border-radius: 16px; font-size: 15px; font-weight: 700; cursor: pointer;
            font-family: inherit; padding: 14px;
        }
        .nomatch:active { transform: scale(.98); }

        /* ---------- Add modal ---------- */
        .modal-overlay {
            display: none; position: fixed; inset: 0; z-index: 60;
            background: rgba(16,35,63,.5); backdrop-filter: blur(2px);
            align-items: flex-start; justify-content: center;
            padding: calc(14vh + env(safe-area-inset-top)) 16px 16px;
        }
        .modal-overlay.open { display: flex; }
        .modal {
            width: 100%; max-width: 420px; background: #fff; border-radius: 20px;
            padding: 20px; box-shadow: 0 20px 60px rgba(0,0,0,.3);
            display: flex; flex-direction: column; gap: 12px;
        }
        .modal h2 { margin: 0; font-size: 18px; font-weight: 800; color: var(--navy); }
        .modal-seg { display: flex; background: #eef0f3; border-radius: 12px; padding: 4px; gap: 4px; }
        .modal-seg button {
            flex: 1; border: 0; background: transparent; color: var(--muted);
            font-size: 14px; font-weight: 700; padding: 9px 6px; border-radius: 9px;
            cursor: pointer; font-family: inherit;
        }
        #msvc-english.active { background: var(--english); color: #fff; }
        #msvc-chinese.active { background: var(--chinese); color: #fff; }
        .modal input {
            width: 100%; padding: 12px 14px; font-size: 16px; font-family: inherit;
            border: 1.5px solid var(--line); border-radius: 12px; outline: none;
        }
        .modal input:focus { border-color: var(--teal); }
        .modal-row { display: flex; gap: 8px; margin-top: 2px; }
        .modal-row button { flex: 1; padding: 13px; font-size: 15px; font-weight: 700; border-radius: 12px; border: 0; cursor: pointer; font-family: inherit; }
        /* Edit mode: no service switch, name only */
        #addModal.editing .modal-seg { display: none; }

        /* ---------- Long-press action sheet ---------- */
        .sheet-overlay {
            display: none; position: fixed; inset: 0; z-index: 70;
            background: rgba(16,35,63,.5); backdrop-filter: blur(2px);
            align-items: flex-end; justify-content: center;
        }
        .sheet-overlay.open { display: flex; }
        .sheet {
            width: 100%; max-width: 480px; background: #fff;
            border-radius: 20px 20px 0 0; padding: 10px 12px calc(12px + env(safe-area-inset-bottom));
            display: flex; flex-direction: column; gap: 8px;
        }
        .sheet-title { text-align: center; font-size: 13px; font-weight: 700; color: var(--muted); padding: 10px 8px 6px; }
        .sheet-btn {
            width: 100%; padding: 16px; font-size: 16px; font-weight: 700; border: 0;
            border-radius: 14px; background: #f2f4f7; color: var(--ink); cursor: pointer; font-family: inherit;
        }
        .sheet-btn:active { transform: scale(.99); }
        .sheet-btn.danger { color: #b91c1c; }
        .sheet-btn.cancel { background: transparent; color: var(--muted); }

        /* ---------- Collapse header on scroll (more names on screen) ---------- */
        body.scrolled .logobar,
        body.scrolled .brand,
        body.scrolled .countcard,
        body.scrolled .toolrow,
        body.scrolled .searchwrap { display: none; }
        body.scrolled .topbar { padding-top: max(6px, env(safe-area-inset-top)); padding-bottom: 6px; }
        body.scrolled .seg { margin-top: 0; }
    </style>
</head>
<body>
    <div class="logobar">
        <img src="{{ asset('images/wvac-logo.jpg') }}" alt="West Valley Christian Alliance Church">
    </div>

    <div class="topbar">
        <div class="brand">
            <div>
                <h1>Sunday Attendance</h1>
                <div class="sub">{{ $selectedLabel }}{{ $isSunday ? '' : ' · (not a Sunday)' }}</div>
            </div>
            <select class="date-select" id="dateSelect" aria-label="Select Sunday">
                @foreach($sundayOptions as $opt)
                    <option value="{{ $opt['value'] }}" @selected($opt['is_selected'])>
                        {{ $opt['label'] }}{{ $opt['is_default'] ? '  •' : ($opt['has_data'] ? '  ✓' : '') }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="seg" role="tablist">
            <button id="seg-english" class="active" onclick="setService('english')">English</button>
            <button id="seg-chinese" onclick="setService('chinese')">中文 Chinese</button>
        </div>

        <div class="countcard">
            <span class="num" id="activeCount">{{ $stats['english']['this'] }}</span>
            <span class="cap">here now</span>
            <span class="trend" id="activeTrend">
                {{ $stats['english']['prev1_label'] }}: {{ $stats['english']['prev1'] }}<br>
                {{ $stats['english']['prev2_label'] }}: {{ $stats['english']['prev2'] }}
            </span>
        </div>

        <div class="toolrow">
            <button class="tool-btn" id="searchToggle" onclick="toggleSearch()">🔍 Search</button>
            <button class="tool-btn" id="addToggle" onclick="openAddModal()">＋ Add person</button>
        </div>

        <div class="searchwrap" id="searchWrap">
            <input type="search" id="searchInput" placeholder="Search names…" autocomplete="off"
                   oninput="applySearch()" enterkeyhint="search">
            <button class="search-clear" id="searchClear" onclick="clearSearch(true)" aria-label="Clear search">✕</button>
        </div>
    </div>

    @foreach(['english', 'chinese'] as $svc)
        <div class="panel {{ $svc === 'english' ? 'active' : '' }}" id="panel-{{ $svc }}">
            <div class="grid" id="grid-{{ $svc }}">
                @foreach($byService[$svc] as $a)
                    <button class="tile" data-id="{{ $a->id }}" data-present="{{ $a->present ? '1' : '0' }}"
                            data-name="{{ $a->name }}" data-zh="{{ $a->name_zh }}"
                            onclick="toggleTile(this)">
                        <span class="tick">✓</span>
                        @if($svc === 'chinese' && $a->name_zh)
                            <span class="nm">{{ $a->name_zh }}</span>
                            <span class="nm2">{{ $a->name }}</span>
                        @else
                            <span class="nm">{{ $a->name }}</span>
                            @if($a->name_zh)<span class="nm2">{{ $a->name_zh }}</span>@endif
                        @endif
                    </button>
                @endforeach

                <div class="empty-hint" id="empty-{{ $svc }}" @style(['display:none' => count($byService[$svc]) > 0])>
                    No one added yet. Tap <strong>＋ Add person</strong> above to add someone.
                </div>
                <button class="nomatch" id="nomatch-{{ $svc }}" onclick="addFromSearch('{{ $svc }}')"></button>
            </div>
        </div>
    @endforeach

    <div class="submitbar">
        <button class="btn-submit" id="submitBtn" onclick="submitAttendance()">
            Submit <span id="submitLabel">English</span> ✉️
        </button>
        <button class="btn-both" id="bothBtn" onclick="submitAttendance('both')">Both</button>
    </div>

    <div class="modal-overlay" id="addModal">
        <div class="modal">
            <h2 id="modalTitle">Add person</h2>
            <div class="modal-seg">
                <button type="button" id="msvc-english" onclick="setModalSvc('english')">English</button>
                <button type="button" id="msvc-chinese" onclick="setModalSvc('chinese')">中文 Chinese</button>
            </div>
            <input type="text" id="m-name" placeholder="Name (English)" autocomplete="off">
            <input type="text" id="m-zh" placeholder="中文名 (optional)" autocomplete="off">
            <div class="modal-row">
                <button class="btn-cancel" onclick="closeAddModal()">Cancel</button>
                <button class="btn-save" id="modalSave" onclick="savePerson()">Add &amp; mark here</button>
            </div>
        </div>
    </div>

    <div class="sheet-overlay" id="personSheet">
        <div class="sheet">
            <div class="sheet-title" id="sheetName"></div>
            <button class="sheet-btn" onclick="editPerson()">✏️ Edit name</button>
            <button class="sheet-btn danger" onclick="deletePerson()">🗑️ Delete</button>
            <button class="sheet-btn cancel" onclick="closeSheet()">Cancel</button>
        </div>
    </div>

    <div class="toast" id="toast"></div>

    <script>
    (() => {
        const csrf = document.querySelector('meta[name="csrf-token"]').content;
        const selectedDate = @json($selectedDate);
        const routes = {
            toggle: @json(route('wvac.attendance.toggle')),
            add:    @json(route('wvac.attendance.add')),
            update: @json(route('wvac.attendance.update')),
            delete: @json(route('wvac.attendance.delete')),
            submit: @json(route('wvac.attendance.submit')),
        };
        const stats = @json($stats);

        let activeService = 'english';

        // ---- Service switching ----
        window.setService = (svc) => {
            activeService = svc;
            document.getElementById('seg-english').classList.toggle('active', svc === 'english');
            document.getElementById('seg-chinese').classList.toggle('active', svc === 'chinese');
            document.getElementById('panel-english').classList.toggle('active', svc === 'english');
            document.getElementById('panel-chinese').classList.toggle('active', svc === 'chinese');
            document.body.classList.toggle('svc-chinese', svc === 'chinese');
            document.body.classList.toggle('svc-english', svc === 'english');
            document.getElementById('submitLabel').textContent = svc === 'chinese' ? 'Chinese' : 'English';
            refreshCount();
            if (history.replaceState) history.replaceState(null, '', '#' + svc);
        };

        function currentCount(svc) {
            return document.querySelectorAll('#grid-' + svc + ' .tile[data-present="1"]').length;
        }
        function refreshCount() {
            document.getElementById('activeCount').textContent = currentCount(activeService);
            const s = stats[activeService];
            document.getElementById('activeTrend').innerHTML =
                s.prev1_label + ': ' + s.prev1 + '<br>' + s.prev2_label + ': ' + s.prev2;
        }

        // ---- Toggle present (optimistic) ----
        window.toggleTile = (el) => {
            if (didLongPress) { didLongPress = false; return; }  // ignore the click after a long-press
            const now = el.dataset.present === '1' ? '0' : '1';
            el.dataset.present = now;               // optimistic
            refreshCount();
            // When checking someone IN after a search, clear the search so the
            // roster is ready for the next person.
            if (now === '1' && searchInput.value.trim()) clearSearch(false);
            post(routes.toggle, { attendee_id: el.dataset.id, date: selectedDate })
                .then(d => {
                    el.dataset.present = d.present ? '1' : '0';
                    refreshCount();
                })
                .catch(() => {
                    el.dataset.present = now === '1' ? '0' : '1';   // revert
                    refreshCount();
                    toast('Network error — try again', true);
                });
        };

        // ---- Search ----
        const searchInput = document.getElementById('searchInput');
        const searchWrap  = document.getElementById('searchWrap');

        window.toggleSearch = () => {
            const open = searchWrap.classList.toggle('open');
            document.getElementById('searchToggle').classList.toggle('active', open);
            if (open) {
                searchInput.focus();
            } else {
                clearSearch(false);
            }
        };

        window.applySearch = () => {
            const q = searchInput.value.trim().toLowerCase();
            searchWrap.classList.toggle('has-text', q.length > 0);

            ['english', 'chinese'].forEach(svc => {
                const grid = document.getElementById('grid-' + svc);
                const tiles = grid.querySelectorAll('.tile');
                let visible = 0;
                tiles.forEach(t => {
                    const hit = !q || t.textContent.toLowerCase().includes(q);
                    t.classList.toggle('hide', !hit);
                    if (hit) visible++;
                });
                // Empty-state hint only when there is genuinely no one and no search.
                const empty = document.getElementById('empty-' + svc);
                if (empty) empty.style.display = (!q && tiles.length === 0) ? '' : 'none';
                // "Add <query>" shortcut when a search matches nobody.
                const nomatch = document.getElementById('nomatch-' + svc);
                if (q && visible === 0) {
                    nomatch.textContent = '+ Add “' + searchInput.value.trim() + '”';
                    nomatch.style.display = 'block';
                } else {
                    nomatch.style.display = 'none';
                }
            });
        };

        // keep=true also collapses the search bar; keep=false just resets it
        window.clearSearch = (keep) => {
            searchInput.value = '';
            applySearch();
            if (keep) {
                searchWrap.classList.remove('open');
                document.getElementById('searchToggle').classList.remove('active');
            } else if (searchWrap.classList.contains('open')) {
                searchInput.focus();
            }
        };

        // ---- Add person (shared modal) ----
        let modalSvc = 'english';
        const addModal = document.getElementById('addModal');

        window.setModalSvc = (svc) => {
            modalSvc = svc;
            document.getElementById('msvc-english').classList.toggle('active', svc === 'english');
            document.getElementById('msvc-chinese').classList.toggle('active', svc === 'chinese');
        };

        let editingId = null, editTile = null;

        window.openAddModal = (svc, prefill) => {
            editingId = null; editTile = null;
            document.getElementById('modalTitle').textContent = 'Add person';
            document.getElementById('modalSave').textContent = 'Add & mark here';
            addModal.classList.remove('editing');
            setModalSvc(svc || activeService);
            document.getElementById('m-name').value = prefill || '';
            document.getElementById('m-zh').value = '';
            addModal.classList.add('open');
            document.getElementById('m-name').focus();
        };
        window.closeAddModal = () => addModal.classList.remove('open');

        // Opened from the "Add <query>" no-match button: prefill the name.
        window.addFromSearch = (svc) => openAddModal(svc, searchInput.value.trim());

        window.savePerson = () => {
            const name = document.getElementById('m-name').value.trim();
            const zh   = document.getElementById('m-zh').value.trim();
            if (!name && !zh) { toast('Enter a name', true); return; }

            // Edit mode: rename an existing person.
            if (editingId) {
                post(routes.update, { attendee_id: editingId, name: name || null, name_zh: zh || null })
                    .then(d => {
                        paintTile(editTile, tileSvc(editTile), d.attendee);
                        closeAddModal();
                        toast('Saved ✓');
                    })
                    .catch(() => toast('Could not save', true));
                return;
            }

            const svc = modalSvc;
            post(routes.add, { name: name || zh, name_zh: zh || null, service: svc, date: selectedDate })
                .then(d => {
                    addTile(svc, d.attendee);
                    closeAddModal();
                    if (searchInput.value.trim()) clearSearch(false);
                    refreshCount();
                    toast('Added ✓');
                })
                .catch(() => toast('Could not add', true));
        };

        // close modal when tapping the backdrop
        addModal.addEventListener('click', e => { if (e.target === addModal) closeAddModal(); });

        // Paint a tile's name (and data-* used by search / edit) for a service.
        function paintTile(btn, svc, a) {
            btn.dataset.name = a.name || '';
            btn.dataset.zh   = a.name_zh || '';
            const primary   = (svc === 'chinese' && a.name_zh) ? a.name_zh : a.name;
            const secondary = (svc === 'chinese' && a.name_zh) ? a.name : (a.name_zh || '');
            btn.innerHTML = '<span class="tick">✓</span>' +
                '<span class="nm"></span>' + (secondary ? '<span class="nm2"></span>' : '');
            btn.querySelector('.nm').textContent = primary;
            if (secondary) btn.querySelector('.nm2').textContent = secondary;
        }

        function tileSvc(t) { return t.closest('.grid').id.replace('grid-', ''); }

        function addTile(svc, a) {
            const grid = document.getElementById('grid-' + svc);
            const btn = document.createElement('button');
            btn.className = 'tile';
            btn.dataset.id = a.id;
            btn.dataset.present = '1';
            btn.setAttribute('onclick', 'toggleTile(this)');
            paintTile(btn, svc, a);
            grid.insertBefore(btn, document.getElementById('empty-' + svc));
            document.getElementById('empty-' + svc).style.display = 'none';
        }

        // ---- Long-press a name → edit / delete ----
        let menuTile = null, pressTimer = null, didLongPress = false, psx = 0, psy = 0;
        const personSheet = document.getElementById('personSheet');

        function openPersonMenu(tile) {
            menuTile = tile;
            document.getElementById('sheetName').textContent = tile.dataset.name || tile.querySelector('.nm').textContent;
            personSheet.style.pointerEvents = 'none';   // let the ghost click pass under the sheet
            personSheet.classList.add('open');
            setTimeout(() => { personSheet.style.pointerEvents = ''; }, 400);
        }
        window.closeSheet = () => { personSheet.classList.remove('open'); menuTile = null; };
        personSheet.addEventListener('click', e => { if (e.target === personSheet) closeSheet(); });

        window.editPerson = () => {
            if (!menuTile) return;
            editingId = menuTile.dataset.id;
            editTile  = menuTile;
            closeSheet();
            document.getElementById('modalTitle').textContent = 'Edit person';
            document.getElementById('modalSave').textContent = 'Save';
            addModal.classList.add('editing');
            document.getElementById('m-name').value = editTile.dataset.name || '';
            document.getElementById('m-zh').value = editTile.dataset.zh || '';
            addModal.classList.add('open');
            document.getElementById('m-name').focus();
        };

        window.deletePerson = () => {
            if (!menuTile) return;
            const tile = menuTile;
            closeSheet();
            post(routes.delete, { attendee_id: tile.dataset.id, date: selectedDate })
                .then(() => { tile.remove(); refreshCount(); toast('Deleted'); })
                .catch(() => toast('Could not delete', true));
        };

        document.querySelectorAll('.grid').forEach(grid => {
            grid.addEventListener('pointerdown', e => {
                const tile = e.target.closest('.tile');
                if (!tile) return;
                didLongPress = false; psx = e.clientX; psy = e.clientY;
                clearTimeout(pressTimer);
                pressTimer = setTimeout(() => {
                    didLongPress = true;
                    if (navigator.vibrate) navigator.vibrate(15);
                    openPersonMenu(tile);
                }, 500);
            });
            grid.addEventListener('pointermove', e => {
                if (pressTimer && (Math.abs(e.clientX - psx) > 10 || Math.abs(e.clientY - psy) > 10)) {
                    clearTimeout(pressTimer); pressTimer = null;
                }
            });
            ['pointerup', 'pointercancel', 'pointerleave'].forEach(ev =>
                grid.addEventListener(ev, () => { clearTimeout(pressTimer); pressTimer = null; }));
            grid.addEventListener('contextmenu', e => e.preventDefault());
        });

        // ---- Collapse the header on scroll so more names fit ----
        let scrollTicking = false;
        window.addEventListener('scroll', () => {
            if (scrollTicking) return;
            scrollTicking = true;
            requestAnimationFrame(() => {
                const y = window.scrollY;
                if (y > 120) document.body.classList.add('scrolled');
                else if (y < 24) document.body.classList.remove('scrolled');
                scrollTicking = false;
            });
        }, { passive: true });

        // ---- Submit ----
        window.submitAttendance = (scope) => {
            scope = scope || activeService;
            const submitBtn = document.getElementById('submitBtn');
            const bothBtn = document.getElementById('bothBtn');
            submitBtn.disabled = true; bothBtn.disabled = true;
            post(routes.submit, { date: selectedDate, service: scope })
                .then(d => toast('📧 Emailed! ' + d.total + ' total present'))
                .catch(() => toast('Could not send email', true))
                .finally(() => { submitBtn.disabled = false; bothBtn.disabled = false; });
        };

        // ---- Date change ----
        document.getElementById('dateSelect').addEventListener('change', function () {
            window.location.href = '?date=' + this.value + '#' + activeService;
        });

        // ---- Helpers ----
        function post(url, body) {
            return fetch(url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                body: JSON.stringify(body),
            }).then(r => { if (!r.ok) throw new Error(r.status); return r.json(); });
        }

        let toastTimer;
        function toast(msg, isErr) {
            const t = document.getElementById('toast');
            t.textContent = msg;
            t.classList.toggle('err', !!isErr);
            t.classList.add('show');
            clearTimeout(toastTimer);
            toastTimer = setTimeout(() => t.classList.remove('show'), 2200);
        }

        // Restore service from hash on load
        setService(location.hash === '#chinese' ? 'chinese' : 'english');
    })();
    </script>
</body>
</html>
