<nav class="navbar bg-primary text-primary-content shadow-lg px-4 md:px-8 mb-[5vh]">    <!-- Logo/Brand -->
    <div class="navbar-start">
        <a href="book.php" class="btn btn-ghost normal-case text-xl">
            📚 LibrarySys
        </a>
    </div>
    
    <!-- Desktop Menu -->
    <div class="navbar-center hidden md:flex">
        <ul class="menu menu-horizontal px-1 gap-2">
            <li><a href="book.php" class="btn-ghost"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>Book</a></li>
            <li><a href="status.php" class="btn-ghost"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>Status</a></li>
        </ul>
    </div>

    <!-- Mobile Menu -->
    <div class="navbar-end md:hidden">
        <div class="dropdown dropdown-end">
            <label tabindex="0" class="btn btn-ghost btn-circle">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" /></svg>
            </label>
            <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                <li><a href="book.php" class="text-gray-700">Book</a></li>
                <li><a href="status.php" class="text-gray-700">Status</a></li>
                <li><a href="profile.php" class="text-gray-700">Profile</a></li>
                <li><a href="../logout.php" class="text-red-500">Logout</a></li>
            </ul>
        </div>
    </div>

    <!-- Desktop Right Section -->
    <div class="navbar-end hidden md:flex">
        <ul class="menu menu-horizontal px-1 gap-2">
            <li><a href="profile.php" class="btn-ghost">👤 Profile</a></li>
            <li><a href="../logout.php" class="btn-ghost text-error">Logout</a></li>
        </ul>
    </div>
</nav>