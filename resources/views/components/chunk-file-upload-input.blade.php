<div id="dropzone-container-{{$suffix}}" class="dropzone-container {{$containerClass}}">
    <div id="dropzone-{{$suffix}}" class="dropzone" style="border: 2px dashed #ccc; padding: 20px; text-align: center;">
        Drag & drop files here or
        <input type="file" id="dropzone-file-{{$suffix}}" class="dropzone-file" />
    </div>
    <div id="progressBar-{{$suffix}}" class="dropzone-progress-bar" style="margin-top: 20px; height: 20px; background: #ccc; width: 100%;">
        <div id="progress-{{$suffix}}"  class="dropzone-progress" style="height: 100%; background: #4caf50; width: 0%;"></div>
    </div>
    <div id="status-{{$suffix}}" class="dropzone-status"></div>
</div>
