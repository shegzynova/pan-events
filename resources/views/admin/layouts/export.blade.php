<div class="dropdown-menu w-40">
    <ul class="dropdown-content">
        <li>
            <a href="{{ route('export-excel', $type) }}" class="dropdown-item"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
                Export to Excel </a>
        </li>
        <li>
            <a href="{{ route('export-pdf', $type) }}" class="dropdown-item"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
                Export to PDF </a>
        </li>
    </ul>
</div>