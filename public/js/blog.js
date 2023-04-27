
let str ='' ;
document.execCommand("defaultParagraphSeparator", false, "p");

let general_selected = Array;
document.onclick = function(e){

    // delete image after user click cross icon to delet image
    if(e.target.classList.contains('remove-icon-image')){
     let name = e.target.parentElement.previousElementSibling.getAttribute('src').split('/').slice(-1)[0];
     // send the name to server by ajax to delet this image in server
        let csrf_token = document.querySelector('[name="_token"]').value ;
        let obj = Object.create({});
        obj['_token'] = csrf_token;
        obj['delet_image']=name;
     $.post('http://blog.com/ajax/delet_image' , obj , function(one , two , there){
            //console.log(one);
            if(one == true){
            }
        });
     console.log(name);
        e.target.parentElement.parentElement.remove()
    }


    // check if user click to youtube icon to set video from youtube ----------
    if(e.target.classList.contains('editro-image-bar-elemet-vedio')){
        document.querySelector('.is-selected').outerHTML = `<p><br></p><div style="width: 100%;display: inline-flex;"><input name=url_youtube placeholder="put url of youtube vedio here " style="font-size: 15px;width: 80%;background: #48454512;border-radius: 5px;margin-left: 10px;margin-right: 20px;height: 35px;padding-left: 10px;border: none;" spellcheck="false" contenteditable="true"><br><div style="">
        <svg xmlns="http://www.w3.org/2000/svg" class="editro-youtube-icon" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="35" height="35" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
            <g>
                <path style="cursor: pointer;" class="editro-youtube-icon" xmlns="http://www.w3.org/2000/svg" d="m.522 17.874c.49 1.738 1.989 2.056 2.089 2.117 2.467.672 16.295.674 18.799 0 1.715-.496 2.03-2.017 2.089-2.117.653-3.474.696-8.003-.03-11.945l.03.196c-.49-1.738-1.989-2.056-2.089-2.117-2.434-.661-16.298-.686-18.799 0-1.715.497-2.03 2.017-2.089 2.117-.699 3.651-.734 7.84 0 11.749zm9.086-2.223v-7.293l6.266 3.652z" fill="#e53935" data-original="#e53935">
                </path>
            </g>
        </svg>
        </div></div><p><br></p>` ;

        //--------- return icons to hidden in + icon
        let icon_image_editro = document.querySelector('.icon-image-editor-svg');
        icon_image_editro.children[0].classList.toggle('rotat-icon');
        let myelement = document.querySelector('.edittor-image-bar');
        myelement.classList.toggle('icon-editor-bar');
        //------------
    }
    //--------------------------------------------------------------------------
    //if user put url and push to the youtube icon to make vedio
    if(e.target.classList.contains('editro-youtube-icon')){
        let url_youtube = document.querySelector('[name=url_youtube]').value;
            document.querySelector('[name=url_youtube]').parentElement.outerHTML = `<p><br></p><div style="width: 100%;display: flex;justify-content: center;align-items: center;background: black;">${url_youtube}</div><p><br></p>` ;

    }

    // if user want to publish this writeup
    if(e.target.classList.contains('pubish_icon')){
        check_writeup();
    }



    // if user click to any option in black bar the bar should displa none
    let elem = document.querySelector('.box_options');
    if (document.querySelector('.box_options').contains(e.target)){
        // Clicked in box
        // console.log(e.target.parentElement.attributes.class.nodeValue);
        // if( e.target.parentElement.attributes.class.nodeValue == 'add-link'){

        // }
      } else{
        document.querySelector('.icon-box').style.display ='flex';
      document.querySelector('.link_input').style.display ='none';
      document.querySelector('.box_options').style.display= 'none';
      }
      //-----------------------------------------------------------------------------------
      // the part of get image from user
      // check in the click in box <p> or not
     let p_elements = document.querySelectorAll('.body_art p');
    p_elements.forEach(function(elemone){

        if(elemone.contains(e.target)){
            let element_icon_image = document.querySelector('.icon-image-editor');
            element_icon_image.style.display = 'none';

            //let texto = elemone.innerHTML.replace('<br>' , '').replace(' ' , '') ;

            let texto = elemone.innerHTML.replace(/(<[^<>]*>|&nbsp;|\s)/g , '');
            //console.log(elemone.innerHTML);
            //console.log(texto);
            if(texto == ''){
                let element_has_select = document.querySelectorAll('.is-selected');
                if(element_has_select){
                    element_has_select.forEach(function(el){
                        el.classList.remove('is-selected');
                    })
                };
                elemone.classList.add('is-selected');
                let poss_elem_cl = elemone.getBoundingClientRect();
                let poss_elem_cl_y = poss_elem_cl.y;
                let poss_elem_cl_x = poss_elem_cl.x;
                element_icon_image.style.display = 'flex'
                element_icon_image.style.top = `${poss_elem_cl_y-4+window.scrollY}px` ;
                element_icon_image.style.left = `${poss_elem_cl_x-50}px`;
                //console.log(elemone.getBoundingClientRect());
            };
        };


    });
      //--------------------------------------------------------------------
    //general_selected = saveSelection();



     str=window.getSelection().anchorNode.data;
     if(str){
         //console.log(str);
     str=str.substring(window.getSelection().anchorOffset,window.getSelection().focusOffset);
     let master = document.querySelector('.body_art').innerHTML
    if(str && master.includes(str)){
        s = window.getSelection();
        let oRange = s.getRangeAt(0); //get the text range
        let oRect = oRange.getBoundingClientRect();
        let x = oRect.x ;
        let y = oRect.y;
        let width = oRect.width;
        let height = oRect.height;
        let x_av = x +(width/2);
        let y_av = y + (height/2);
        //let elem = document.querySelector('.test');
        elem.style.display= 'none';
        elem.style.display= 'block';
        elem.style.top = `${y_av-55+window.scrollY}px`;
        elem.style.left = `${x_av}px`;


    }
}

}

let icons = document.querySelectorAll('.iconi');
if(icons){
    icons.forEach(function(elem){
        elem.onclick = function(){
            str_all=window.getSelection().anchorNode.data;
            if(str_all){
            str_part=str_all.substring(window.getSelection().anchorOffset,window.getSelection().focusOffset);
            // the list of actions
            //1-upper_case
            let id_name = this.id;
            switch (id_name){
                case 'upper':
                            if (window.getSelection().focusNode.parentElement.classList.contains('do')){
                                window.getSelection().focusNode.parentElement.outerHTML = window.getSelection().focusNode.parentElement.innerHTML ;
                            }else{

                                    let selected_h2 = window.getSelection();
                                document.execCommand("insertHTML",false,`  <h2 class='do with' style='margin-left:30px;color: #403e3ed6;'>${selected_h2}</h2><p><br></p>`);
                            }
                            document.querySelector('.box_options').style.display= 'none';
                            break;
                case 'lower':
                            if (window.getSelection().focusNode.parentElement.classList.contains('do')){
                                window.getSelection().focusNode.parentElement.outerHTML = window.getSelection().focusNode.parentElement.innerHTML ;
                            }else{
                                    let selected_h4 = window.getSelection();
                                document.execCommand("insertHTML",false,`  <h4 class='do'>${selected_h4}</h4>  `);
                            }
                            document.querySelector('.box_options').style.display= 'none';
                            break;
                case 'bold':
                            if (window.getSelection().focusNode.parentElement.classList.contains('do')){
                                window.getSelection().focusNode.parentElement.outerHTML = window.getSelection().focusNode.parentElement.innerHTML ;
                            }else{
                                let selected_str = window.getSelection();
                                document.execCommand("insertHTML",false,`  <strong class='do' >${selected_str}</strong>  `);

                            }
                            document.querySelector('.box_options').style.display= 'none';
                            break;
                case 'Italic':
                            if (window.getSelection().focusNode.parentElement.classList.contains('do')){
                                window.getSelection().focusNode.parentElement.outerHTML = window.getSelection().focusNode.parentElement.innerHTML ;
                            }else{
                                let selected_i = window.getSelection();
                                document.execCommand("insertHTML",false,`  <i class='do' >${selected_i}</i>                        `);

                            }
                            document.querySelector('.box_options').style.display= 'none';
                            break;
                 case 'comma':
                            if (window.getSelection().focusNode.parentElement.classList.contains('do')){
                                window.getSelection().focusNode.parentElement.outerHTML = window.getSelection().focusNode.parentElement.innerHTML ;
                            }else{
                                let selected_span = window.getSelection();
                                document.execCommand("insertHTML",false,`<span class='do comma' >${selected_span}</span>`);

                            }
                            document.querySelector('.box_options').style.display= 'none';
                            break;



            }


            }
        };
    });
}


// for link editor
let icon_link = document.getElementById('link');
if(icon_link){
    icon_link.onclick = function(){
        general_selected = saveSelection();
        console.log(general_selected);
        document.querySelector('.icon-box').style.display ='none';
      document.querySelector('.link_input').style.display ='flex';

    }
}

let add_link = document.querySelector('.add-link');
if(add_link){
    add_link.onclick = function(){
        //console.log('ys');
        restoreSelection(general_selected)
         let selected = window.getSelection();

       document.execCommand("insertHTML",false,"<a class='links' target='_blank' href='"+ document.querySelector('[name=link]').value +" 'style=\"text-decoration: none; color: #4a4af4e0; font-weight: 400;\" >"+selected+"</a>");
         document.querySelector('.icon-box').style.display ='flex';
         document.querySelector('.link_input').style.display ='none';
         document.querySelector('.box_options').style.display= 'none';

    }
}

function saveSelection() {
    if (window.getSelection) {
        sel = window.getSelection();
        if (sel.getRangeAt && sel.rangeCount) {
            var ranges = [];
            for (var i = 0, len = sel.rangeCount; i < len; ++i) {
                ranges.push(sel.getRangeAt(i));
            }
            return ranges;
        }
    } else if (document.selection && document.selection.createRange) {
        return document.selection.createRange();
    }
    return null;
}

function restoreSelection(savedSel) {
    if (savedSel) {
        if (window.getSelection) {
            sel = window.getSelection();
            sel.removeAllRanges();
            for (var i = 0, len = savedSel.length; i < len; ++i) {
                sel.addRange(savedSel[i]);
            }
        } else if (document.selection && savedSel.select) {
            savedSel.select();
        }
    }
}



// let icon_span_clicked = document.querySelectorAll('.icon-span');
// if(icon_span_clicked){

//     icon_span_clicked.forEach(function(elemtwo){
//         elemtwo.onclick = function(){
//             console.log('yes');
//             document.querySelectorAll('.icon-span-bar').forEach(function(elethree){
//                 elethree.style.display = 'block';
//             });
//         }
//     })

// }

// diplay editor bar to get image or vedio ;
let icon_image_editro = document.querySelector('.icon-image-editor-svg');
if(icon_image_editro){
    icon_image_editro.onclick = function(){
        this.children[0].classList.toggle('rotat-icon');
        let myelement = document.querySelector('.edittor-image-bar');
      myelement.classList.toggle('icon-editor-bar');

    }
}


// action after choose image
let camera_input = document.querySelector('[name="camera"]');
if(camera_input){
    camera_input.onchange = function(){
        let file = this.files[0];
        let url = URL.createObjectURL(this.files[0]);
        let name = this.files[0].name;
        //send image to server first then return ulr relatedet ot server
        let csrf_token = document.querySelector('[name="_token"]').value ;
        let selected = this ;
        let formData = new FormData();
        formData.append('image', this.files[0]);
        formData.append('_token' ,csrf_token);
        $.ajax({
            url : 'http://blog.com/ajax/writeup',
            type : 'POST',
            data : formData,
            processData: false,
              // tell jQuery not to process the data
           contentType: false,
           // tell jQuery not to set content-Type
           success : function(data) {
            let code_html = `<p><br></p><div class='image-element' style="width: 100%;position: relative;border: 3px solid transparent;">
            <img class='image-mouse' src="${data}" alt="" style="width: 100%;z-index: 1;">
            <div class="remove-icon" style="display: none; position: absolute;z-index: 2;right: 10px;top:10px;">
            <img class='remove-icon-image' style="width: 30px;" src="https://cdn-icons-png.flaticon.com/512/1828/1828615.png" alt="">

            </div>
            </div><p><br></p><p><br></p>`
            document.querySelector('.is-selected').outerHTML = code_html ;
            //--------- return icons to hidden in + icon
        let icon_image_editro = document.querySelector('.icon-image-editor-svg');
        icon_image_editro.children[0].classList.toggle('rotat-icon');
        let myelement = document.querySelector('.edittor-image-bar');
        myelement.classList.toggle('icon-editor-bar');
        //------------

           }
       });



    }
};




 //delet the image when user click cross in image
//  document.addEventListener('click' , function(e){

//     if(e.target.classList.contains('remove-icon-path')){
//         console.log(e.target.parentElement.parentElement.parentElement.parentElement.classList.add('youssefshibl'));
//         //document.querySelector('.deleted').remove();
//     }

//  })



function check_writeup(){
    // first get title
    let title_writeup = document.querySelector('.title-of').value.replace(/(<[^<>]*>|&nbsp;|\s)/g , '') ;
    // check if title empty
    if(title_writeup == ''){
        bootbox.alert("you should write title ");
    }else{
        if(title_writeup.length < 2){
            bootbox.alert("the title should be greeter than 15 character");
        }else{
            // get the body of writeup
            let body_writeup = document.querySelector('.body_art').innerHTML ;
            let body_writeup_pure = body_writeup.replace(/(<[^<>]*>|&nbsp;|\s)/g , '');
            if(body_writeup_pure == ''){
            bootbox.alert("you should write body");
            }else{
                // check the min of character in boduy
                if(body_writeup_pure.length < 5){
                    bootbox.alert("the body should be greeter than 100 character");
                }else{
                    // check if you add new writeup of you edit  old writeup
                    let url_name = document.querySelector('.pubish_icon').innerHTML.replace(/(<[^<>]*>|&nbsp;|\s)/g , '');
                    // is save that mean that is old
                    //console.log(url_name);
                    if(url_name == 'Save'){
                        choose_tags();
                       // send_data_writeup();
                    }else{
                        if(document.querySelector('[name="image-main-writeup"]').files.length == 0){
                            bootbox.alert("you should choose image of your write-up");
                        }else{
                            choose_tags();

                        }
                    }





                }
            }

        }
    }


}


function choose_tags(){
    document.querySelector('.main-box-tags').style.zIndex = '1';
    document.querySelector('.main-box-tags').style.opacity = '1';
}

// exit from tages select box
document.querySelector('.exit-tag').onclick = function(){
    document.querySelector('.main-box-tags').style.zIndex = '-1';
    document.querySelector('.main-box-tags').style.opacity = '0';
}
// make ok to tags select box
document.querySelector('.ok-tags').onclick = function(){
    document.querySelector('.main-box-tags').style.zIndex = '-1';
    document.querySelector('.main-box-tags').style.opacity = '0';
    send_data_writeup();
}


function send_data_writeup(){
    // get data from website title & list_name & body
    let response ;
    let list = document.querySelector('[name="list"]').value;
    let title = document.querySelector('.title-of').value.replace(/(<[^<>]*>|&nbsp;)/g , '');
    let body = document.querySelector('.body_art').innerHTML ;
    let csrf_token = document.querySelector('[name="_token"]').value ;
    let url_name = document.querySelector('.pubish_icon').innerHTML.replace(/(<[^<>]*>|&nbsp;|\s)/g , '');

    let key_url='';
    let post_id = 0;
    var data = new FormData();
    data.append('list' , list);
    data.append('title' , title);
    data.append('body',body);
    data.append('tags' , GetSelectionTags());
    data.append('_token' , csrf_token);
    data.append('main_image' , document.querySelector('[name="image-main-writeup"]').files[0] ?? '');
    if(url_name == 'Save'){
        post_id = document.querySelector('[name="post_id"]').value;
        key_url = `/${post_id}`;
        //data._method = 'PUT';
        data.append('_method' , 'PUT');

    }else if(url_name == 'Publish')
    {
        key_url = '';
        //data._method = 'POST';
        data.append('_method' , 'POST');

    }
    //console.log( data.get('_method'));
    //console.log(data);
    //console.log('http://blog.com/posts'  + key_url );
    var dialog = bootbox.dialog({
        message: '<p class="text-center mb-0"><i class="fa fa-spin fa-cog"></i>Please wait while we do something...</p>',
        closeButton: false
    });
    //console.log(key_url);
    //send data to backend with ajax
    $.ajax({
        url : 'http://blog.com/posts' + key_url, data,
        type : 'POST',
        data : data ,
        processData: false,
          // tell jQuery not to process the data
       contentType: false,
       // tell jQuery not to set content-Type
       success : function(one) {
           //console.log("this is test");
           dialog.modal('hide');
            console.log(one);
            if(one.status == true){
                if(key_url != ''){
                    bootbox.alert(' <i style="margin-left: 10px;margin-right: 10px;font-size: 20px;color: #06b006;" class="fa-solid fa-circle-check"></i> go to this writeup after change  <a href="http://blog.com/posts' + key_url +'">GO</a>');
                }
            }else{
                let message_error = '';
                one.message.forEach(function(elem){
                    message_error += elem + '<br>';
                })
                bootbox.alert({
                    message: message_error,
                    className: 'rubberBand animated'
                });

            }

       }
   });

}



// add main image of writeup
document.querySelector('[name="image-main-writeup"]').onchange = function(element){
    let image = []
    image.push({
         'name' : this.files[0].name,
         'url' : URL.createObjectURL(this.files[0]),
         'file' : this.files[0] ,
    })
    //document.querySelector('.image-profile img').setAttribute('src' , image[0]['url']);
    document.querySelector('.image-main-writeup').innerHTML = `<img src="${image[0]['url']}" style="width: 100%;" alt="">`;
}


function GetSelectionTags(){
    let tags = [];
    document.querySelectorAll('.select2-selection__choice__display').forEach(function(Element){
        tags.push(Element.innerText);
      });
    return tags;
}
