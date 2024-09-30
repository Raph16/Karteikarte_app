<div x-data="{
    alert: true, 
    messages: @json(session('messages', [])),
    currentMessageIndex: 0,
    showNextMessage() {
        if (this.currentMessageIndex < this.messages.length) {
            this.alert = true;
            setTimeout(() => {
                this.alert = false;
                this.currentMessageIndex++;
                this.showNextMessage();
            }, 2500);
        }
    }
}"
x-init="showNextMessage()"
x-show="alert && messages.length > 0"
class="flex items-center p-4 mb-4 text-sm {{ ($type=='success') ? 'border bg-green-50 text-green-400 border-green-800' : ' border  bg-yellow-50 text-yellow-300 border-yellow-800' }}  rounded-lg  dark:bg-gray-800"
role="alert" id="message">
<i class="w-4 h-4 me-3 {{ ($type ==='success') ? 'ri-checkbox-circle-line' : 'ri-close-circle-line' }}"></i>
<span class="sr-only">Info</span>
<div>
    <span class="font-medium" x-text="messages[currentMessageIndex].type === 'success' ? 'Success: ' : 'Echec: '"></span> 
    <span x-text="messages[currentMessageIndex].text"></span>.
</div>
<button type="button" @click="alert = !alert">
    <i class="absolute top-1 end-1 fa-solid fa-close flex-none fill-current h-3 w-3 {{ ($type ==='success') ? 'text-green-600' : 'text-red-600' }}"></i>
</button>
</div>
