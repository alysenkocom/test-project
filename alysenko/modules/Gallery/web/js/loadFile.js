
if (window.File && window.FileReader && window.FileList && window.Blob) {

    function humanFileSize(bytes, si) {
        var thresh = si ? 1000 : 1024;
        if(bytes < thresh) return bytes + ' B';
        var units = si ? ['kB','MB','GB','TB','PB','EB','ZB','YB'] : ['KiB','MiB','GiB','TiB','PiB','EiB','ZiB','YiB'];
        var u = -1;
        do {
            bytes /= thresh;
            ++u;
        } while(bytes >= thresh);
        return bytes.toFixed(1)+' '+units[u];
    }

    function renderImage(file){
        var reader = new FileReader();
        reader.onload = function(event){
            the_url = event.target.result;
            //of course using a template library like handlebars.js is a better solution than just inserting a string
            $('#preview').html("<div class=\"thumbnail\"><img class=\"img-responsive\" src='" + the_url + "' /></div>");
            $('#name').html(file.name);
            $('#size').html(humanFileSize(file.size, "MB"));
            $('#type').html(file.type);
        };

        //when the file is read it triggers the onload event above.
        reader.readAsDataURL(file);
    }

    //watch for change on the
    $( "#images-source_img" ).change(function() {
        console.log(this.files[0].size);
        renderImage(this.files[0]);
    });
}
