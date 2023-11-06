<div class="relative before:hidden before:lg:block before:absolute before:w-[69%] before:h-[3px] before:top-0 before:bottom-0 before:mt-4 before:bg-slate-100 before:dark:bg-darkmode-400 flex flex-col lg:flex-row justify-center px-5 sm:px-20">

    @php
        $pages = [ 'Setup User Details', 'Accommodation', /*'Abstract Submission',*/ 'Exhibitions', 'Finalize and Pay'];

        $session = session('purchase');
        $type = optional($session)['type'];

        if($type == 'exhibition'){
            array_splice($pages, 2, 0, 'Exhibition');
        }

        if($type == 'speaker'){
            array_splice($pages, 2, 0, 'Abstract');
        }

    @endphp

    @foreach ($pages as $index => $pageLabel)
        @php
            $isActive = $page == $index + 1;
//            dd($isActive, $page, $index);
            $activeClass = $isActive ? 'btn-primary' : 'text-slate-500 bg-slate-100 dark:bg-darkmode-400 dark:border-darkmode-400';
            $textClass = $isActive ? '' : 'text-slate-600 dark:text-slate-400';
        @endphp
        <div class="intro-x lg:text-center flex items-center mt-5 lg:mt-0 lg:block flex-1 z-10">
            <button class="w-10 h-10 rounded-full btn {{ $activeClass }}">{{ $index + 1 }}</button>
            <div class="lg:w-32 text-base lg:mt-3 ml-3 lg:mx-auto {{ $textClass }}">{{ $pageLabel }}</div>
        </div>
    @endforeach

</div>
