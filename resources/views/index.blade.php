<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} MCP docs</title>
    <style>
        :root {
            color-scheme: light;
            --bg: #ffffff;
            --sidebar-bg: #e8edf6;
            --sidebar-line: #d5ddea;
            --nav-active: #c7def1;
            --nav-hover: #dce8f4;
            --ink: #2d2d2d;
            --muted: #5f6673;
            --line: #d7deea;
            --surface: #edf2fa;
            --panel: #ffffff;
            --dark-panel: #252e3f;
            --dark-panel-soft: #303a4f;
            --dark-panel-ink: #eef3fb;
            --orange: #ff6b2c;
            --warn-bg: #fff7ed;
            --warn-ink: #9a3412;
        }

        html {
            scroll-behavior: smooth;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--bg);
            color: var(--ink);
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            line-height: 1.55;
        }

        code {
            border: 1px solid var(--line);
            border-radius: 2px;
            background: #f3f6fb;
            padding: 1px 5px;
            font-size: .9em;
        }

        pre {
            overflow-x: auto;
            width: 100%;
            max-width: 100%;
            margin: 12px 0 0;
            border: 0;
            border-radius: 4px;
            background: #111827;
            color: var(--dark-panel-ink);
            padding: 18px;
            font-size: .875rem;
            line-height: 1.45;
        }

        pre code {
            display: block;
            border: 0;
            border-radius: 0;
            background: transparent;
            color: inherit;
            padding: 0;
            font: inherit;
            white-space: pre;
        }

        a {
            color: inherit;
        }

        h1, h2, h3 {
            line-height: 1.2;
            margin: 0;
        }

        h1 {
            color: var(--ink);
            font-size: 2.35rem;
            letter-spacing: 0;
        }

        h2 {
            font-size: 1.35rem;
        }

        h3 {
            font-size: 1rem;
        }

        p {
            margin: 0;
        }

        .docs-shell {
            display: grid;
            grid-template-columns: 300px minmax(0, 1fr);
            min-height: 100vh;
        }

        .sidebar {
            position: sticky;
            top: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
            border-right: 1px solid var(--sidebar-line);
            background: var(--sidebar-bg);
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 35px 16px 34px;
            font-size: 1rem;
            font-weight: 800;
        }

        .nav-server,
        .nav-tool {
            display: block;
            text-decoration: none;
        }

        .sidebar-title {
            color: var(--ink);
            font-size: .76rem;
            font-weight: 900;
            letter-spacing: .06em;
            margin: 24px 16px 14px;
            text-transform: uppercase;
        }

        .nav-server {
            color: var(--ink);
            font-size: .875rem;
            font-weight: 400;
            padding: 8px 16px;
        }

        .nav-server:hover,
        .nav-tool:hover {
            background: var(--nav-hover);
        }

        .nav-tools {
            display: grid;
            gap: 0;
            list-style: none;
            margin: 0 0 8px;
            padding: 0;
        }

        .sidebar-subtitle {
            color: var(--muted);
            font-size: .68rem;
            font-weight: 900;
            letter-spacing: .08em;
            margin: 8px 16px 4px 30px;
            text-transform: uppercase;
        }

        .nav-tool {
            color: var(--ink);
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            font-size: .78rem;
            overflow: hidden;
            padding: 6px 16px 6px 30px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        main {
            min-width: 0;
            padding: 72px 104px 80px;
        }

        .content {
            width: min(960px, 100%);
            min-width: 0;
            margin: 0 auto;
        }

        .page-header {
            margin-bottom: 24px;
        }

        .count {
            display: inline-block;
            margin-top: 12px;
            white-space: nowrap;
            border-radius: 999px;
            background: var(--dark-panel);
            color: #ffffff;
            padding: 2px 8px;
            font-size: .78rem;
            font-weight: 700;
        }

        .empty {
            border: 1px solid var(--line);
            background: var(--surface);
            color: var(--muted);
            padding: 18px;
        }

        .server {
            margin-top: 22px;
            scroll-margin-top: 24px;
        }

        .server-header {
            border: 1px solid var(--line);
            background: var(--panel);
        }

        .server-title {
            padding: 22px 24px 12px;
        }

        .meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 12px;
        }

        .pill {
            border-radius: 999px;
            background: #eef3f8;
            padding: 2px 8px;
            color: var(--muted);
            font-size: .82rem;
        }

        .url-panel {
            background: var(--dark-panel);
            color: var(--dark-panel-ink);
        }

        .url-panel-title {
            border-bottom: 1px solid var(--dark-panel-soft);
            color: #c9d2df;
            padding: 12px 18px;
        }

        .url-row {
            display: flex;
            gap: 10px;
            align-items: center;
            margin: 0;
            padding: 16px 18px 18px;
        }

        .server-url {
            display: block;
            min-width: 0;
            flex: 1;
            border: 0;
            border-radius: 0;
            background: #1f293a;
            color: var(--dark-panel-ink);
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            font-size: .9rem;
            overflow-x: auto;
            padding: 10px 12px;
            white-space: nowrap;
        }

        .copy-button {
            border: 1px solid #7f8ba1;
            border-radius: 2px;
            background: #ffffff;
            color: var(--ink);
            cursor: pointer;
            font: inherit;
            font-size: .85rem;
            padding: 7px 10px;
        }

        .copy-button:hover {
            background: #f3f6fb;
        }

        .instructions {
            border-top: 1px solid var(--line);
            color: var(--muted);
            padding: 16px 24px;
        }

        .tools {
            display: grid;
            gap: 22px;
            min-width: 0;
            margin-top: 28px;
        }

        .tool {
            border: 1px solid var(--line);
            background: var(--panel);
            scroll-margin-top: 24px;
            min-width: 0;
        }

        .tool-heading {
            display: flex;
            flex-wrap: wrap;
            align-items: baseline;
            gap: 10px;
            border-bottom: 1px solid var(--line);
            background: #f4f7fb;
            padding: 12px 18px;
        }

        .tool-name {
            color: var(--ink);
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            font-weight: 800;
        }

        .tool-body {
            padding: 18px;
        }

        details {
            margin-top: 12px;
            min-width: 0;
            max-width: 100%;
        }

        .schema-tabs {
            margin-top: 16px;
            min-width: 0;
        }

        .schema-tab-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0;
            margin-bottom: 12px;
        }

        .schema-tab {
            border: 1px solid var(--line);
            border-bottom: 0;
            border-radius: 0;
            background: #f3f6fb;
            color: var(--ink);
            cursor: pointer;
            font: inherit;
            font-size: .9rem;
            padding: 8px 12px;
        }

        .schema-tab + .schema-tab {
            border-left: 0;
        }

        .schema-tab[aria-selected="true"] {
            background: var(--dark-panel);
            border-color: var(--dark-panel);
            color: #ffffff;
        }

        .schema-panel {
            display: none;
            min-width: 0;
        }

        .schema-panel.is-active {
            display: block;
        }

        .schema-table-wrap {
            overflow-x: auto;
            border: 1px solid var(--line);
            background: #ffffff;
        }

        .schema-table {
            width: 100%;
            border-collapse: collapse;
            font-size: .9rem;
        }

        .schema-table th,
        .schema-table td {
            border-right: 1px solid var(--line);
            border-bottom: 1px solid var(--line);
            padding: 14px 16px;
            text-align: left;
            vertical-align: top;
        }

        .schema-table th {
            background: #f7f8fb;
            color: var(--ink);
            font-weight: 800;
        }

        .schema-table th:last-child,
        .schema-table td:last-child {
            border-right: 0;
        }

        .schema-table tr:last-child td {
            border-bottom: 0;
        }

        .field-type {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .field-presence {
            color: var(--muted);
            font-size: .82rem;
        }

        .schema-empty {
            border: 1px solid var(--line);
            background: #f7f8fb;
            color: var(--muted);
            padding: 14px 16px;
        }

        summary {
            cursor: pointer;
            color: var(--ink);
            font-weight: 700;
        }

        @media (max-width: 900px) {
            .docs-shell {
                display: block;
            }

            .sidebar {
                position: static;
                height: auto;
                border-right: 0;
                border-bottom: 1px solid var(--sidebar-line);
            }

            .sidebar-brand {
                padding: 20px 16px;
            }

            main {
                padding: 32px 16px 48px;
            }

            .count {
                margin-top: 12px;
            }

            .url-row {
                display: block;
            }

            .copy-button {
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="docs-shell">
        <aside class="sidebar" aria-label="MCP documentation navigation">
            <div class="sidebar-brand">{{ config('app.name') }} MCP docs</div>
            <nav>
                @if (count($servers) > 0)
                    <p class="sidebar-title">Servers</p>
                    @foreach ($servers as $server)
                        <a class="nav-server" href="#{{ $server['anchor'] }}">{{ $server['name'] }}</a>
                        @if (count($server['tools']) > 0)
                            <p class="sidebar-subtitle">Tools</p>
                            <ol class="nav-tools">
                                @foreach ($server['tools'] as $tool)
                                    <li>
                                        <a class="nav-tool" href="#{{ $tool['anchor'] }}">{{ $tool['name'] }}</a>
                                    </li>
                                @endforeach
                            </ol>
                        @endif
                    @endforeach
                @endif
            </nav>
        </aside>

        <main>
            <div class="content">
                <header class="page-header" id="overview">
                    <div>
                        <h1>{{ config('app.name') }} MCP docs</h1>
                    </div>
                    <div class="count">{{ count($servers) }} {{ Str::plural('server', count($servers)) }}</div>
                </header>

                @if (count($servers) > 0)
                    @foreach ($servers as $serverIndex => $server)
                        <section class="server" id="{{ $server['anchor'] }}">
                            <div class="server-header">
                                <div class="server-title">
                                    <h2>{{ $server['name'] }}</h2>
                                    <div class="meta">
                                        <span class="pill">Version {{ $server['version'] }}</span>
                                        <span class="pill">{{ count($server['tools']) }} {{ Str::plural('tool', count($server['tools'])) }}</span>
                                    </div>
                                </div>
                                <div class="url-panel">
                                    <div class="url-panel-title">MCP Server URL</div>
                                    <div class="url-row">
                                        <code class="server-url"><strong>Live Server:</strong> {{ $server['url'] }}</code>
                                        <button class="copy-button" type="button" data-copy-value="{{ $server['url'] }}" onclick="copyUrl(this)">Copy</button>
                                    </div>
                                </div>
                                @if ($server['instructions'] !== '')
                                    <p class="instructions">{{ $server['instructions'] }}</p>
                                @endif
                            </div>

                            <div class="tools">
                                @forelse ($server['tools'] as $toolIndex => $tool)
                                    <article class="tool" id="{{ $tool['anchor'] }}">
                                        <div class="tool-heading">
                                            <span class="tool-name">{{ $tool['name'] }}</span>
                                            @if (! empty($tool['title']))
                                                <h3>{{ $tool['title'] }}</h3>
                                            @endif
                                        </div>

                                        <div class="tool-body">
                                            @if (! empty($tool['description']))
                                                <p>{{ $tool['description'] }}</p>
                                            @endif

                                            @if (array_key_exists('inputSchema', $tool) || array_key_exists('outputSchema', $tool))
                                                @php
                                                    $hasInputSchema = array_key_exists('inputSchema', $tool);
                                                    $hasOutputSchema = array_key_exists('outputSchema', $tool);
                                                    $inputFields = $hasInputSchema ? \Sezy\LaravelMcpDocumentationGenerator\Support\SchemaDocumentation::fields($tool['inputSchema']) : [];
                                                    $outputFields = $hasOutputSchema ? \Sezy\LaravelMcpDocumentationGenerator\Support\SchemaDocumentation::fields($tool['outputSchema']) : [];
                                                @endphp
                                                <div class="schema-tabs">
                                                    <div class="schema-tab-list" role="tablist" aria-label="{{ $tool['name'] }} schemas">
                                                        @if ($hasInputSchema)
                                                            <button
                                                                class="schema-tab"
                                                                type="button"
                                                                role="tab"
                                                                aria-selected="true"
                                                                aria-controls="schema-readable-input-{{ $serverIndex }}-{{ $toolIndex }}"
                                                                onclick="showSchemaTab(this, 'schema-readable-input-{{ $serverIndex }}-{{ $toolIndex }}')"
                                                            >Input</button>
                                                        @endif
                                                        @if ($hasOutputSchema)
                                                            <button
                                                                class="schema-tab"
                                                                type="button"
                                                                role="tab"
                                                                aria-selected="{{ $hasInputSchema ? 'false' : 'true' }}"
                                                                aria-controls="schema-readable-output-{{ $serverIndex }}-{{ $toolIndex }}"
                                                                onclick="showSchemaTab(this, 'schema-readable-output-{{ $serverIndex }}-{{ $toolIndex }}')"
                                                            >Output</button>
                                                        @endif
                                                        @if ($hasInputSchema)
                                                            <button
                                                                class="schema-tab"
                                                                type="button"
                                                                role="tab"
                                                                aria-selected="false"
                                                                aria-controls="schema-input-{{ $serverIndex }}-{{ $toolIndex }}"
                                                                onclick="showSchemaTab(this, 'schema-input-{{ $serverIndex }}-{{ $toolIndex }}')"
                                                            >Input schema</button>
                                                        @endif
                                                        @if ($hasOutputSchema)
                                                            <button
                                                                class="schema-tab"
                                                                type="button"
                                                                role="tab"
                                                                aria-selected="false"
                                                                aria-controls="schema-output-{{ $serverIndex }}-{{ $toolIndex }}"
                                                                onclick="showSchemaTab(this, 'schema-output-{{ $serverIndex }}-{{ $toolIndex }}')"
                                                            >Output schema</button>
                                                        @endif
                                                    </div>

                                                    @if ($hasInputSchema)
                                                        <div class="schema-panel is-active" id="schema-readable-input-{{ $serverIndex }}-{{ $toolIndex }}" role="tabpanel">
                                                            @if (count($inputFields) > 0)
                                                                <div class="schema-table-wrap">
                                                                    <table class="schema-table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Param</th>
                                                                                <th>Type</th>
                                                                                <th>Description</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($inputFields as $field)
                                                                                <tr>
                                                                                    <td><code>{{ $field['name'] }}</code></td>
                                                                                    <td>
                                                                                        <span class="field-type">
                                                                                            <code>{{ $field['type'] }}</code>
                                                                                            <span class="field-presence">{{ $field['required'] ? 'required' : 'optional' }}</span>
                                                                                        </span>
                                                                                    </td>
                                                                                    <td>{{ $field['description'] !== '' ? $field['description'] : 'No description.' }}</td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            @else
                                                                <p class="schema-empty">No documented input fields.</p>
                                                            @endif
                                                        </div>

                                                        <div class="schema-panel" id="schema-input-{{ $serverIndex }}-{{ $toolIndex }}" role="tabpanel">
                                                            <pre><code>{{ \Sezy\LaravelMcpDocumentationGenerator\Support\Json::pretty($tool['inputSchema']) }}</code></pre>
                                                        </div>
                                                    @endif

                                                    @if ($hasOutputSchema)
                                                        <div class="schema-panel {{ $hasInputSchema ? '' : 'is-active' }}" id="schema-readable-output-{{ $serverIndex }}-{{ $toolIndex }}" role="tabpanel">
                                                            @if (count($outputFields) > 0)
                                                                <div class="schema-table-wrap">
                                                                    <table class="schema-table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Field</th>
                                                                                <th>Type</th>
                                                                                <th>Description</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($outputFields as $field)
                                                                                <tr>
                                                                                    <td><code>{{ $field['name'] }}</code></td>
                                                                                    <td>
                                                                                        <span class="field-type">
                                                                                            <code>{{ $field['type'] }}</code>
                                                                                            <span class="field-presence">{{ $field['required'] ? 'required' : 'optional' }}</span>
                                                                                        </span>
                                                                                    </td>
                                                                                    <td>{{ $field['description'] !== '' ? $field['description'] : 'No description.' }}</td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            @else
                                                                <p class="schema-empty">No documented output fields.</p>
                                                            @endif
                                                        </div>

                                                        <div class="schema-panel" id="schema-output-{{ $serverIndex }}-{{ $toolIndex }}" role="tabpanel">
                                                            <pre><code>{{ \Sezy\LaravelMcpDocumentationGenerator\Support\Json::pretty($tool['outputSchema']) }}</code></pre>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif

                                        </div>
                                    </article>
                                @empty
                                    <p class="empty">No tools found for this MCP web server.</p>
                                @endforelse
                            </div>
                        </section>
                    @endforeach
                @else
                    <p class="empty">No MCP web servers found.</p>
                @endif
            </div>
        </main>
    </div>
    <script>
        function copyUrl(button) {
            const value = button.getAttribute('data-copy-value');

            if (! value || ! navigator.clipboard) {
                return;
            }

            navigator.clipboard.writeText(value).then(() => {
                const original = button.textContent;

                button.textContent = 'Copied';

                window.setTimeout(() => {
                    button.textContent = original;
                }, 1200);
            });
        }

        function showSchemaTab(button, panelId) {
            const tabs = button.closest('.schema-tabs');

            if (! tabs) {
                return;
            }

            tabs.querySelectorAll('.schema-tab').forEach((tab) => tab.setAttribute('aria-selected', 'false'));
            tabs.querySelectorAll('.schema-panel').forEach((panel) => panel.classList.remove('is-active'));

            button.setAttribute('aria-selected', 'true');
            tabs.querySelector(`#${panelId}`)?.classList.add('is-active');
        }
    </script>
</body>
</html>
