<x-app-layout>
    <div class="w-full max-w-lg mx-auto my-10">
        <div class="bg-white rounded-xl shadow-lg p-8 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
            <div class="text-center mb-6">
                <h2 class="text-purple-600 text-2xl font-semibold">Create New Project</h2>
                <p class="text-gray-500 mt-2">Fill out the details to create your amazing new project</p>
            </div>

            <form action="{{ route('project.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-5">
                    <label for="name" class="block text-purple-600 font-medium mb-2">Project Name</label>
                    <input type="text" name="name" id="name"  placeholder="Enter project name"
                           value="{{old('name')}}"
                           class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-200 bg-gray-50 text-gray-800 transition">
                    @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="description" class="block text-purple-600 font-medium mb-2">Description</label>
                    <textarea name="description" id="description"  placeholder="Describe your project..."
                              class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-200 bg-gray-50 text-gray-800 min-h-32 resize-y transition">{{old('description')}}</textarea>
                    @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-5">
                    <label class="block text-purple-600 font-medium mb-2">Project Images</label>
                    <div class="relative">
                        <label for="image" class="flex flex-col items-center justify-center w-full p-6 bg-purple-50 border-2 border-dashed border-purple-300 rounded-lg cursor-pointer hover:bg-purple-100 transition">
                            <div class="text-purple-600 text-3xl mb-2">📁</div>
                            <div class="text-purple-700 font-medium text-center">
                                Drop images here or click to browse
                                <p class="text-sm text-gray-500 mt-1">You can select multiple images</p>
                            </div>
                        </label>
                        <input type="file" name="images[]" id="image" accept="image/*" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    </div>
                    @error('images')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    @foreach ($errors->get('images.*') as $messages)
                        @foreach ($messages as $message)
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @endforeach
                    @endforeach
                    <div class="mt-2">
                        <div id="file-preview" class="hidden flex flex-wrap gap-2"></div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-4 rounded-lg transition flex items-center justify-center gap-2 hover:-translate-y-0.5 hover:shadow-lg active:translate-y-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    Create Project
                </button>
            </form>
        </div>
    </div>
@push('scripts')
        <script>
            // Display selected files
            document.getElementById('image').addEventListener('change', function(e) {
                const filePreview = document.getElementById('file-preview');
                filePreview.innerHTML = '';
                filePreview.classList.remove('hidden');
                filePreview.classList.add('flex');

                Array.from(this.files).forEach(file => {
                    const fileItem = document.createElement('div');
                    fileItem.className = 'bg-purple-50 rounded-md px-3 py-1.5 text-sm text-purple-700 flex items-center gap-1.5';
                    fileItem.innerHTML = `
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
            <circle cx="8.5" cy="8.5" r="1.5"></circle>
            <polyline points="21 15 16 10 5 21"></polyline>
          </svg>
          ${file.name.length > 15 ? file.name.substring(0, 15) + '...' : file.name}
        `;
                    filePreview.appendChild(fileItem);
                });

                if (this.files.length === 0) {
                    filePreview.classList.add('hidden');
                    filePreview.classList.remove('flex');
                }
            });
        </script>
@endpush

</x-app-layout>
