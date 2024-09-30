<div class="is-hoverable is-scrollbar-hidden min-w-full overflow-x-auto">
    <div class="flex justify-between items-center px-2">
        <x-action methods="console.log('refreshed');" time=1000 wMsg=false methodeWire='freshCards' class="mt-2 p-2 outline outline-violet-800 text-violet-300 rounded-lg hover:bg-violet-800 hover:text-white/85 " spinerClass="border-yello-600 bg-transparent">
            refresh <i class="ri-refresh-line ml-2"></i>
        </x-action>
        <span class="p-2 ml-2 text-violet-300 font-semibold">Anzahl Karten: {{ count($Cards) }}</span>
    </div>
  <table class="is-zebra w-full text-left my-2 py-2 rtl:text-right text-gray-500 dark:text-gray-400">
      <thead>
          <tr>
              <th class="whitespace-nowrap rounded-l-lg bg-slate-200 px-3 py-2 font-semibold capitalize text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">N°</th>
              <th class="whitespace-nowrap bg-slate-200 px-4 py-2 font-semibold capitalize text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">Stapel</th>
              <th class="whitespace-nowrap bg-slate-200 px-4 py-2 font-semibold capitalize text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">Ersteller</th>
              <th class="whitespace-nowrap rounded-r-lg bg-slate-200 px-3 py-2 font-semibold capitalize text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">Inhalt</th>
              <th class="whitespace-nowrap rounded-r-lg bg-slate-200 px-3 py-2 font-semibold capitalize text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">Action</th>
          </tr>
      </thead>
      <tbody>
          @forelse ($Cards as $Card)
          {{-- @dump($Card) --}}
              <tr class="hover:text-white hover:bg-black/45">
                  <td class="text-white/85 whitespace-nowrap rounded-l-lg px-4 py-3 sm:px-5">{{ $loop->index + 1 }}</td>
                  <td class="text-white/85 whitespace-nowrap px-4 py-3 sm:px-5">{{ $Card->deck_name }}</td>
                  <td class="text-white/85 whitespace-nowrap px-4 py-3 sm:px-5">{{ $Card->deck_author }}</td>
                  <td class="text-white/85 whitespace-nowrap rounded-r-lg px-4 py-3 sm:px-5">{{ Str::limit($Card->question, 20) }}</td>
                  <td class="text-white/85 whitespace-nowrap rounded-r-lg px-4 py-3 sm:px-5 font-bold" @freshCard=" console.log('Hello World!') " x-data="{ modalConfirm: false, calledCardEditForm: false }">
                      <x-action wMsg=false methods='calledCardEditForm=true;' time=1000 methodeWire='' color='red' class="text-violet-400" spinerClass="border-blue-600">
                          <i class="ri-file-edit-line"></i>
                      </x-action>
                      <x-action methods="modalConfirm=true;" time=1000 wMsg=false color='red' class="text-red-400" spinerClass="border-red-600">
                          <i class="ri-delete-bin-6-line"></i>
                      </x-action>
                      <div x-show="calledCardEditForm">
                        <x-modal show="calledCardEditForm" name='Modifier la carte' @close="closeModal; $dispatch('freshCard'); window.livewire.emit('freshCards')" title="Modifier une carte" >
                            <livewire:forms.card  :targetCardId="$Card->card_code" wire:key="{{ str()->random(17).$Card->card_code }}"/>
                            <button @click=" calledCardEditForm=false" wire:click="freshCards" > 
                                <i class="ri-close-fill absolute top-2 end-2"></i>
                            </button>
                        </x-modal>
                       </div>
                      <template x-if="modalConfirm">
                          <x-modal show="modalConfirm" name='Supression de carte' @close="modalConfirm=false" title="Supprimer une carte">
                              <div id="alert-additional-content-2" class="p-4 text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
                                  <div class="flex items-center">
                                      <svg class="flex-shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                          <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                      </svg>
                                      <span class="sr-only">Info</span>
                                      <h3 class="text-lg font-medium capitalize">Löschen</h3>
                                  </div>
                                  <div class="mt-2 mb-4 text-sm">Möchten sie diese Karte Wirklich löschen ?</div>
                                  <div class="flex gap-2">
                                    <x-action methods="modalConfirm=false;" time=1000 methodeWire="deleteCard({{ $Card->card_code }})" class="capitalize text-red-800 font-medium rounded-lg p-1.5 text-xs text-center border border-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-800 dark:text-white/80 ">
                                        Löschen <i class="ml-1 ri-delete-bin-6-line"></i>
                                    </x-action>
                                    <x-action methods="modalConfirm=false;" class="text-red-800 bg-transparent border border-red-800 hover:bg-red-900 hover:text-white focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center dark:hover:bg-red-600 dark:border-red-600 dark:text-red-500 dark:hover:text-white dark:focus:ring-red-800" data-dismiss-target="#alert-additional-content-2" aria-label="Close">
                                        Abbrechen
                                    </x-action>
                                </div>
                              </div>
                          </x-modal>
                      </template>
                  </td>
              </tr>
          @empty
              <tr class="border-b border-gray-700">
                  <td colspan="5" class="p-4">
                      <div id="alert-additional-content-4" class="p-4 mb-4  border rounded-lg bg-yellow-800 text-yellow-300 border-yellow-800" role="alert">
                          <div class="flex items-center">
                              <svg class="flex-shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                  <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                              </svg>
                              <span class="sr-only">Info</span>
                              <h3 class="text-lg font-medium">{{ ucfirst('Keine Karten gefunden') }} !</h3>
                          </div>
                      </div>
                  </td>
              </tr>
          @endforelse
      </tbody>
      @if (session()->has('success'))
          <tr class="border-b border-gray-200 dark:border-gray-700">
              <td colspan="5" class="my-2 p-2">
                  <x-alert type="success">
                      {{ session('success') }}
                  </x-alert>
              </td>
          </tr>
      @elseif (session()->has('echec'))
          <tr class="border-b border-gray-200 dark:border-gray-700">
              <td colspan="5" class="my-2 p-2">
                  <x-alert type="echec">
                      {{ session('echec') }}
                  </x-alert>
              </td>
          </tr>
      @endif
  </table>
  <div class="flex justify-end p-2 gap-3">
      {{ $Cards->links() }}
  </div>
</div>
