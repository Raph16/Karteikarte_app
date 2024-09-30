<div x-data="{ alert : true }" x-init="setTimeout(() => alert = false, 5000)"  x-show="alert" class="flex items-center p-4 mb-4 text-sm {{ ($type=='success') ? 'border bg-transparent shadow-green-500 text-green-400 border-green-800' : ' border  bg-transparent shadow-yellow-500 text-yellow-300 border-yellow-800' }}  rounded-lg  dark:bg-gray-800 " role="alert" id="message">
    <i class="flex-shrink-0 inline w-4 h-4 me-3 {{ ($type ==='success') ? 'ri-checkbox-circle-line' : 'ri-close-circle-line' }}"></i>
    <span class="sr-only">Info</span>
    <div>
      <span class="font-medium">{{ ($type ==='success') ? 'Success: ' : 'Echec: ' }}</span> {{ $slot }}.
    </div>
    <button type="button" @click=" alert = !alert ">
        <i class="absolute top-1 end-1 fa-solid fa-close flex-none fill-current h-3 w-3 {{ ($type ==='success') ? 'text-green-600' : 'text-red-600' }}"></i>
      </button>
  </div>