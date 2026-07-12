@props([
    'id', 
    'route', 
    'columns', 
    'title' => 'Management', 
    'description' => '', 
    'createRoute' => null, 
    'createLabel' => 'Add New'
])

<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-6 px-4 sm:px-6 lg:px-8 transition-colors duration-200">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700/70 overflow-hidden">
            
            <!-- Header Section -->
            <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-lg font-bold text-gray-900 dark:text-white">{{ $title }}</h1>
                    @if($description)
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $description }}</p>
                    @endif
                </div>
                @if($createRoute)
                    <a href="{{ $createRoute }}" class="inline-flex items-center justify-center px-3.5 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 rounded-lg shadow-sm transition-colors">
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        {{ $createLabel }}
                    </a>
                @endif
            </div>

            <!-- Alerts Container -->
            <div class="px-5 pt-4">
                <x-alert-message/>
                @if(session('error'))
                    <div class="p-3 mb-2 text-xs text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 border border-red-200 dark:border-red-900/50 flex items-center justify-between">
                        <span>{{ session('error') }}</span>
                        <button type="button" class="text-red-500 hover:text-red-700" onclick="this.parentElement.remove()">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                @endif
            </div>

            <!-- Custom Controls -->
            <div class="p-5 pb-3 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="flex items-center space-x-2 text-xs text-gray-600 dark:text-gray-400 w-full sm:w-auto">
                    <span>Show</span>
                    <select id="{{ $id }}-length" class="bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white rounded-lg p-1.5 text-xs font-medium outline-none w-14">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span>entries</span>
                </div>
                
                <div class="w-full sm:w-64 relative">
                    <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none text-gray-400">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="search" id="{{ $id }}-search" placeholder="Search..." class="w-full pl-8 pr-3 py-1.5 text-xs bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white placeholder-gray-400 rounded-lg outline-none focus:ring-1 focus:ring-blue-500">
                </div>
            </div>

            <!-- Table Block -->
            <div class="overflow-x-auto w-full border-t border-gray-200 dark:border-gray-700">
                <table id="{{ $id }}" class="w-full text-xs text-left text-gray-600 dark:text-gray-300 border-collapse">
                    <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-900/50 text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700">
                        <tr>
                            {{ $slot }}
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800"></tbody>
                </table>
            </div>

            <!-- Pagination Footer -->
            <div class="p-5 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div id="{{ $id }}-info" class="text-xs text-gray-500 dark:text-gray-400 font-medium"></div>
                <div id="{{ $id }}-pagination" class="inline-flex space-x-1"></div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        var tableId = '#{{ $id }}';
        var table = $(tableId).DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ $route }}',
            columns: @json($columns),
            dom: "t",
            pageLength: 10,
            responsive: true,
            autoWidth: false,
            drawCallback: function (settings) {
                var api = this.api();
                var pageInfo = api.page.info();
                
                if (pageInfo.recordsTotal === 0) {
                    $(tableId + '-info').text('Showing 0 to 0 of 0 entries');
                } else {
                    $(tableId + '-info').text('Showing ' + (pageInfo.start + 1) + ' to ' + pageInfo.end + ' of ' + pageInfo.recordsTotal + ' entries');
                }

                var container = $(tableId + '-pagination').empty();
                var baseBtn = "px-2.5 py-1 text-xs font-medium rounded border transition-all select-none ";
                var active = "bg-blue-600 text-white border-blue-600 dark:bg-blue-500 dark:border-blue-500";
                var inactive = "bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800";
                var disabled = "opacity-40 cursor-not-allowed bg-gray-100 dark:bg-gray-900 text-gray-400 border-gray-200 dark:border-gray-800 pointer-events-none";

                var prev = $('<button class="' + baseBtn + (pageInfo.page === 0 ? disabled : inactive) + '">Prev</button>');
                prev.on('click', function() { if(pageInfo.page > 0) api.page('previous').draw('page'); });
                container.append(prev);

                for (var i = 0; i < pageInfo.pages; i++) {
                    (function(idx) {
                        var isCurrent = (pageInfo.page === idx);
                        var numBtn = $('<button class="' + baseBtn + (isCurrent ? active : inactive) + '">' + (idx + 1) + '</button>');
                        numBtn.on('click', function() { api.page(idx).draw('page'); });
                        container.append(numBtn);
                    })(i);
                }

                var next = $('<button class="' + baseBtn + (pageInfo.page >= pageInfo.pages - 1 ? disabled : inactive) + '">Next</button>');
                next.on('click', function() { if(pageInfo.page < pageInfo.pages - 1) api.page('next').draw('page'); });
                container.append(next);
            }
        });

        $(tableId + '-search').on('keyup change clear', function () {
            table.search($(this).val()).draw();
        });

        $(tableId + '-length').on('change', function () {
            table.page.len($(this).val()).draw();
        });
    });
</script>
@endpush
