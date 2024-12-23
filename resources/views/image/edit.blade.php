@extends('layouts.app')
@section('content')
<div class="container">

    {{-- <a href="/relojes/{{$producto->slug}}" class="btn btn-warning"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back</a> --}}
    <h2>
        {{$producto->nombre}}

        <a  href="/catalogo/{{ $producto->catalogoM->slug }}/{{$producto->slug}}" class="btn btn-sm stylish-color mdb-color white-text" style="padding-left: 15px; padding-right:15px">Ver</a>
    </h2>
    {{-- Subir imagen --}}
    <div class="row mt-2">
        <div class="col-md-12">
            <form action="{{ route('imageSave') }}" enctype="multipart/form-data" method="POST">@csrf
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <h4 class="card-title">Upload image</h4>
                            </div>
                            <div class="col">
                                <span class="pull-right btn btn-success btn-sm" onclick="document.getElementById('inputImg').click()"> <i class="fa fa-upload fa-2x"></i></span>
                                <input type="file" id="inputImg" style="display: none" name="img" accept="image/*" onchange="onchace(this)">
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        {{-- <h5 class="card-title">Special title treatment</h5> --}}
                        <div class="row">
                            <div class="col-md-4 col-xs-6" id="col"></div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 col-xs-6">
                                <span class="btn btn-success cropx" style="display:none" onclick="croppear('gallery')"><i class="fa fa-crop" aria-hidden="true"></i> Recortar </span>    
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-muted">
                        <button class="btn btn-success" style="display:none" id="upload_button" type="submit">
                            <i class="fa fa-upload" aria-hidden="true"></i> Upload
                        </button>
                    </div>
                  </div>

                  <input class="form-control" style="display:none" name="id" type="text" value="{{$producto->id}}">
                  <input class="form-control" style="display:none" id="medidas_crop" name="medidas_crop" type="text">
                  <input class="form-control" style="display:none" id="es_gallery" name="es_gallery" type="text">
            </form>
        </div>
    </div>
    {{-- fin Subir imagen --}}

{{-- mostrar, ordenar y eliminar imagenes --}}
<div class="row mt-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Gallery</h4>
            </div>
            <div class="card-body">
            @if ($producto->imagenes->count() == 0)
                <span style="margin-left:50%; margin-top:50%">Sin Imagenes</span>
            @endif

    <ul id="items" style="list-style-type: none;">@foreach ($producto->imagenes as $img)
        <li style="float: left; margin-top: 15px; margin-right: 15px">
            <figure class="imghvr-push-up">
                <img alt="" src="/storage/productos/thumb_{{$img->ruta}}" id="{{$img->ruta}}" class="img_drag" style="width:200px;">
                <figcaption  style="background-color: #dddddd; justify-content: center;align-items: center; padding:0%">
                    <form action="{{ route('imageDelete') }}" enctype="multipart/form-data" method="POST">@csrf
                        <input style="display:none" name="id" type="text" value="{{$img->id}}">
                        <input style="display:none" name="producto_id" type="text" value="{{$producto->id}}">
                        <button class="btn btn-danger btn-sm" style="margin-top:5%; margin-left: 5%; padding: 10px ">
                            <i class="fa fa-trash fa-2x" aria-hidden="true"></i>
                        </button>
                    </form>
                    <br>
                    <span class="btn btn-default btn-sm" style="margin-top:30%; margin-left: 75%; padding: 10px ">
                        <i class="fa fa-arrows fa-2x" aria-hidden="true"></i>
                    </span>
                </figcaption>
            </figure>
        </li> @endforeach
    </ul>

    </div><div class="card-footer">

    <form action="{{ route('imageUpdate') }}" enctype="multipart/form-data" method="POST">@csrf
        <input style="display:none" name="id" type="text" value="{{$producto->id}}">
        <input style="display:none" id="datos_imgs" name="datos_imgs" type="text">
        @if ($producto->imagenes->count() == 0)
            <button id="updateOrden" type="submit" style="display: none" class="btn btn-success" onclick="update()">Save</button>   
        @endif       
    </form>


</div></div></div></div>
{{-- fin mostrar, ordenar y eliminar imagenes --}}

</div>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.10.1/Sortable.min.js"></script>
<script>
        var datos_imgs, es, inputImg, col, buttonsCrop, upload_button, inputMedidasCrop, es_gallery, image_show, imgs_sort, el, sortable, updateOrden;
    function update() {
        datos_imgs = document.getElementById('datos_imgs');
        es = document.getElementsByClassName("img_drag");
        inputImg = document.querySelector("#inputImg");
        col = document.querySelector("#col");
        buttonsCrop = document.getElementsByClassName("cropx");
        upload_button = document.getElementById('upload_button');
        inputMedidasCrop = document.getElementById('medidas_crop');
        es_gallery = document.getElementById("es_gallery");
        el = document.getElementById('items');
        updateOrden = document.getElementById('updateOrden');
        image_show = "";
        imgs_sort = [];
        datos_imgs.value = "";
        for (var i = 0; i < es.length; i++) {
            var e = es[i];
            imgs_sort.push({name: e.id, peso: i})            
        }
        datos_imgs.value = JSON.stringify(imgs_sort);
        
        // Simple list
        sortable = Sortable.create(el);
        sortable = new Sortable(el, {
            group: "name",  // or { name: "...", pull: [true, false, 'clone', array], put: [true, false, array] }
            sort: true,  // sorting inside list
            delay: 0, // time in milliseconds to define when the sorting should start
            delayOnTouchOnly: false, // only delay if user is using touch
            touchStartThreshold: 0, // px, how many pixels the point should move before cancelling a delayed drag event
            disabled: false, // Disables the sortable if set to true.
            store: null,  // @see Store
            animation: 150,  // ms, animation speed moving items when sorting, `0` — without animation
            easing: "cubic-bezier(1, 0, 0, 1)", // Easing for animation. Defaults to null. See https://easings.net/ for examples.
            handle: ".my-handle",  // Drag handle selector within list items
            filter: ".ignore-elements",  // Selectors that do not lead to dragging (String or Function)
            preventOnFilter: true, // Call `event.preventDefault()` when triggered `filter`
            draggable: ".item",  // Specifies which items inside the element should be draggable
            dataIdAttr: 'data-id',
            ghostClass: "sortable-ghost",  // Class name for the drop placeholder
            chosenClass: "sortable-chosen",  // Class name for the chosen item
            dragClass: "sortable-drag",  // Class name for the dragging item
            swapThreshold: 1, // Threshold of the swap zone
            invertSwap: false, // Will always use inverted swap zone if set to true
            invertedSwapThreshold: 1, // Threshold of the inverted swap zone (will be set to swapThreshold value by default)
            direction: 'horizontal', // Direction of Sortable (will be detected automatically if not given)
            forceFallback: false,  // ignore the HTML5 DnD behaviour and force the fallback to kick in
            fallbackClass: "sortable-fallback",  // Class name for the cloned DOM Element when using forceFallback
            fallbackOnBody: false,  // Appends the cloned DOM Element into the Document's Body
            fallbackTolerance: 0, // Specify in pixels how far the mouse should move before it's considered as a drag.
            dragoverBubble: false,
            removeCloneOnHide: true, // Remove the clone element when it is not showing, rather than just hiding it
            emptyInsertThreshold: 5, // px, distance mouse must be from empty sortable to insert drag element into it

            setData: function (/** DataTransfer */dataTransfer, /** HTMLElement*/dragEl) {
                console.log('setData')
                dataTransfer.setData('Text', dragEl.textContent); // `dataTransfer` object of HTML5 DragEvent
            },

            // Element is chosen
            onChoose: function (/**Event*/evt) {
                console.log('onChoose')
                evt.oldIndex;  // element index within parent
            },

            // Element is unchosen
            onUnchoose: function(/**Event*/evt) {
                console.log('onUnchoose')
                // same properties as onEnd
            },

            // Element dragging started
            onStart: function (/**Event*/evt) {
                console.log('onStart')
                evt.oldIndex;  // element index within parent
            },

            // Element dragging ended
            onEnd: function (/**Event*/evt) {
                console.log('onEnd')
                var itemEl = evt.item;  // dragged HTMLElement
                evt.to;    // target list
                evt.from;  // previous list
                evt.oldIndex;  // element's old index within old parent
                evt.newIndex;  // element's new index within new parent
                evt.oldDraggableIndex; // element's old index within old parent, only counting draggable elements
                evt.newDraggableIndex; // element's new index within new parent, only counting draggable elements
                evt.clone // the clone element
                evt.pullMode;  // when item is in another sortable: `"clone"` if cloning, `true` if moving
            },

            // Element is dropped into the list from another list
            onAdd: function (/**Event*/evt) {
                console.log('onAdd')
                // same properties as onEnd
            },

            // Changed sorting within list
            onUpdate: function (/**Event*/evt) {
                console.log('onUpdate')
                // same properties as onEnd
            },

            // Called by any change to the list (add / update / remove)
            onSort: function (/**Event*/evt) {
                console.log('onSort')
                // same properties as onEnd
            },

            // Element is removed from the list into another list
            onRemove: function (/**Event*/evt) {
                console.log('onRemove')
                // same properties as onEnd
            },

            // Attempt to drag a filtered element
            onFilter: function (/**Event*/evt) {
                console.log('onFilter')
                var itemEl = evt.item;  // HTMLElement receiving the `mousedown|tapstart` event.
            },

            // Event when you move an item in the list or between lists
            onMove: function (/**Event*/evt, /**Event*/originalEvent) {
                console.log('onMove')
                updateOrden.style.display = "inline-block";
                // Example: https://jsbin.com/nawahef/edit?js,output
                evt.dragged; // dragged HTMLElement
                evt.draggedRect; // DOMRect {left, top, right, bottom}
                evt.related; // HTMLElement on which have guided
                evt.relatedRect; // DOMRect
                evt.willInsertAfter; // Boolean that is true if Sortable will insert drag element after target by default
                originalEvent.clientY; // mouse position
                // return false; — for cancel
                // return -1; — insert before target
                // return 1; — insert after target
            },

            // Called when creating a clone of element
            onClone: function (/**Event*/evt) {
                console.log('onClone')
                var origEl = evt.item;
                var cloneEl = evt.clone;
            },

            // Called when dragging element changes position
            onChange: function(/**Event*/evt) {
                console.log('onChange')
                evt.newIndex // most likely why this event is used is to get the dragging element's current index
                // same properties as onEnd
            }
        });
    }


    //seleccionar y mostrar imagen
    function onchace(e) {
        inputMedidasCrop.value = "";
        if (image_show) {
            image_show.remove();
        }
        if (e.files.length > 0) {
            let reader = new FileReader();
            // Leemos el archivo subido y se lo pasamos a nuestro fileReader
            reader.readAsDataURL(e.files[0]);
            // Le decimos que cuando este listo ejecute el código interno
            reader.onload = function(){
                let preview = document.getElementById('col');
                image = document.createElement('img');
                image.src = reader.result;
                image.id = "image_show";
                image.classList.add("img-fluid");
                preview.innerHTML = '';
                preview.append(image);
                for (let i = 0; i < buttonsCrop.length; i++) {
                    buttonsCrop[i].style.display = "inline-block";
                    upload_button.style.display = "none";
                }
            }
        }
    }

    //recortar la imagen
    function croppear (tipo) {
        var imgData = {
            resume: false,
            order: "",
            name: "",
            x: "",
            y: "",
            width: "",
            height: ""
        }
        var aspectRatio = 1 / 1;
        es_gallery.value = 'true';
        for (let i = 0; i < buttonsCrop.length; i++) {
                buttonsCrop[i].style.display = "none";
                upload_button.style.display = "inline-block";               
        }
        var image_show = document.getElementById("image_show");
        var cropper = new Cropper(image_show, {aspectRatio: aspectRatio,
            crop(e) { 
                var i = e.detail;
                imgData.x = i.x;
                imgData.y = i.y;
                imgData.w = i.width;
                imgData.h = i.height;
                inputMedidasCrop.value = JSON.stringify(imgData);
            },
        });
    }

    //funcion principal
    window.onload = function() {
        update();
    };

</script>
@endsection
