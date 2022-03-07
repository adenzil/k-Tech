<form method="POST" id="csvUpload" @submit.prevent="submitCsvFile($event)">
   <label class="border-2 border-gray-200 p-3 w-full block rounded cursor-pointer my-2" for="customFile" >
      <input type="file" class="sr-only" id="customFile" name="files" @change="updateFile($event)">
         <span x-text="files ? files.map(file => file.name).join(', ') : 'Click here to upload Stock CSV...'"></span>
      </label>
   </label>
   <input type="submit" x-show="files" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer float-right" />
</form>