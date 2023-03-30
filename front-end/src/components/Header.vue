<template>
<header aria-label="Site Header" class="bg-white w-full flex justify-between px-12">
  <div class="flex h-16 max-w-screen-xl items-center px-4 sm:px-6 lg:px-8">
    <a class="block text-teal-600" href="/">
      <span class="sr-only">Home</span>
        logo
    </a>
    </div>
    <div class="flex items-center gap-4">
        <div class="sm:flex sm:gap-4">
          <a class="block rounded-md bg-teal-600 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-teal-700" href="">Login</a>
          <a class="hidden rounded-md bg-gray-100 px-5 py-2.5 text-sm font-medium text-teal-600 transition hover:text-teal-600/75 sm:block" href="/" > Register </a>
        </div>

        <button class="block rounded bg-gray-100 p-2.5 text-gray-600 transition hover:text-gray-600/75 md:hidden">
          <span class="sr-only">Toggle menu</span>
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M4 6h16M4 12h16M4 18h16"
            />
          </svg>
        </button>
      </div>
</header>

</template>

<script setup>

</script>