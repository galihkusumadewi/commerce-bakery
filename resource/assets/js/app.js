/*
Template: POSDash - Responsive Bootstrap 4 Admin Dashboard Template
Author: iqonicthemes.in
Design and Developed by: iqonicthemes.in
NOTE: This file contains the styling for responsive Template.
*/

/*----------------------------------------------
Index Of Script
------------------------------------------------

:: Tooltip
:: Fixed Nav
:: Magnific Popup
:: Ripple Effect
:: Sidebar Widget
:: FullScreen
:: Page Loader
:: Counter
:: Progress Bar
:: Page Menu
:: Close  navbar Toggle
:: Mailbox
:: chatuser
:: chatuser main
:: Chat start
:: todo Page
:: user toggle
:: Data tables
:: Form Validation
:: Active Class for Pricing Table
:: Flatpicker
:: Scrollbar
:: checkout
:: Datatables
:: image-upload
:: video
:: Button
:: Pricing tab

------------------------------------------------
Index Of Script
----------------------------------------------*/

(function (jQuery) {
  "use strict";

  /*---------------------------------------------------------------------
        Tooltip
        -----------------------------------------------------------------------*/
  jQuery('[data-toggle="popover"]').popover();
  jQuery('[data-toggle="tooltip"]').tooltip();

  /*---------------------------------------------------------------------
        Fixed Nav
        -----------------------------------------------------------------------*/

  $(window).on("scroll", function () {
    if ($(window).scrollTop() > 0) {
      $(".iq-top-navbar").addClass("fixed");
    } else {
      $(".iq-top-navbar").removeClass("fixed");
    }
  });

  $(window).on("scroll", function () {
    if ($(window).scrollTop() > 0) {
      $(".white-bg-menu").addClass("sticky-menu");
    } else {
      $(".white-bg-menu").removeClass("sticky-menu");
    }
  });

  /*---------------------------------------------------------------------
        Magnific Popup
        -----------------------------------------------------------------------*/
  if (typeof $.fn.magnificPopup !== typeof undefined) {
    jQuery(".popup-gallery").magnificPopup({
      delegate: "a.popup-img",
      type: "image",
      tLoading: "Loading image #%curr%...",
      mainClass: "mfp-img-mobile",
      gallery: {
        enabled: true,
        navigateByImgClick: true,
        preload: [0, 1], // Will preload 0 - before current, and 1 after the current image
      },
      image: {
        tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
        titleSrc: function (item) {
          return item.el.attr("title") + "<small>by Marsel Van Oosten</small>";
        },
      },
    });
    jQuery(".popup-youtube, .popup-vimeo, .popup-gmaps").magnificPopup({
      disableOn: 700,
      type: "iframe",
      mainClass: "mfp-fade",
      removalDelay: 160,
      preloader: false,
      fixedContentPos: false,
    });
  }

  /*---------------------------------------------------------------------
        Ripple Effect
        -----------------------------------------------------------------------*/
  jQuery(document).on("click", ".iq-waves-effect", function (e) {
    // Remove any old one
    jQuery(".ripple").remove();
    // Setup
    let posX = jQuery(this).offset().left,
      posY = jQuery(this).offset().top,
      buttonWidth = jQuery(this).width(),
      buttonHeight = jQuery(this).height();

    // Add the element
    jQuery(this).prepend("<span class='ripple'></span>");

    // Make it round!
    if (buttonWidth >= buttonHeight) {
      buttonHeight = buttonWidth;
    } else {
      buttonWidth = buttonHeight;
    }

    // Get the center of the element
    let x = e.pageX - posX - buttonWidth / 2;
    let y = e.pageY - posY - buttonHeight / 2;

    // Add the ripples CSS and start the animation
    jQuery(".ripple")
      .css({
        width: buttonWidth,
        height: buttonHeight,
        top: y + "px",
        left: x + "px",
      })
      .addClass("rippleEffect");
  });

  /*---------------------------------------------------------------------
        Sidebar Widget
        -----------------------------------------------------------------------*/

  jQuery(document).on("click", ".iq-menu > li > a", function () {
    jQuery(".iq-menu > li > a").parent().removeClass("active");
    jQuery(this).parent().addClass("active");
  });

  // Active menu
  var parents = jQuery("li.active").parents(".iq-submenu.collapse");

  parents.addClass("show");

  parents.parents("li").addClass("active");
  jQuery('li.active > a[aria-expanded="false"]').attr("aria-expanded", "true");

  /*---------------------------------------------------------------------
        FullScreen
        -----------------------------------------------------------------------*/
  jQuery(document).on("click", ".iq-full-screen", function () {
    let elem = jQuery(this);
    if (
      !document.fullscreenElement &&
      !document.mozFullScreenElement && // Mozilla
      !document.webkitFullscreenElement && // Webkit-Browser
      !document.msFullscreenElement
    ) {
      // MS IE ab version 11

      if (document.documentElement.requestFullscreen) {
        document.documentElement.requestFullscreen();
      } else if (document.documentElement.mozRequestFullScreen) {
        document.documentElement.mozRequestFullScreen();
      } else if (document.documentElement.webkitRequestFullscreen) {
        document.documentElement.webkitRequestFullscreen(
          Element.ALLOW_KEYBOARD_INPUT
        );
      } else if (document.documentElement.msRequestFullscreen) {
        document.documentElement.msRequestFullscreen(
          Element.ALLOW_KEYBOARD_INPUT
        );
      }
    } else {
      if (document.cancelFullScreen) {
        document.cancelFullScreen();
      } else if (document.mozCancelFullScreen) {
        document.mozCancelFullScreen();
      } else if (document.webkitCancelFullScreen) {
        document.webkitCancelFullScreen();
      } else if (document.msExitFullscreen) {
        document.msExitFullscreen();
      }
    }
    elem
      .find("i")
      .toggleClass("ri-fullscreen-line")
      .toggleClass("ri-fullscreen-exit-line");
  });

  /*---------------------------------------------------------------------
        Page Loader
        -----------------------------------------------------------------------*/
  jQuery("#load").fadeOut();
  jQuery("#loading").delay().fadeOut("");

  /*---------------------------------------------------------------------
        Counter
        -----------------------------------------------------------------------*/
  if (window.counterUp !== undefined) {
    const counterUp = window.counterUp["default"];
    const $counters = $(".counter");
    $counters.each(function (ignore, counter) {
      var waypoint = new Waypoint({
        element: $(this),
        handler: function () {
          counterUp(counter, {
            duration: 1000,
            delay: 10,
          });
          this.destroy();
        },
        offset: "bottom-in-view",
      });
    });
  }

  /*---------------------------------------------------------------------
        Progress Bar
        -----------------------------------------------------------------------*/
  jQuery(".iq-progress-bar > span").each(function () {
    let progressBar = jQuery(this);
    let width = jQuery(this).data("percent");
    progressBar.css({
      transition: "width 2s",
    });

    setTimeout(function () {
      progressBar.appear(function () {
        progressBar.css("width", width + "%");
      });
    }, 100);
  });

  jQuery(".progress-bar-vertical > span").each(function () {
    let progressBar = jQuery(this);
    let height = jQuery(this).data("percent");
    progressBar.css({
      transition: "height 2s",
    });
    setTimeout(function () {
      progressBar.appear(function () {
        progressBar.css("height", height + "%");
      });
    }, 100);
  });

  /*---------------------------------------------------------------------
        Page Menu
        -----------------------------------------------------------------------*/
  jQuery(document).on("click", ".wrapper-menu", function () {
    jQuery(this).toggleClass("open");
    jQuery('.header-logo').css({ width: "100%" });
  });

  jQuery(document).on("click", ".wrapper-menu", function () {
    jQuery("body").toggleClass("sidebar-main");
    jQuery('.header-logo').css({ width: "97px" });
  });

  /*---------------------------------------------------------------------
       Close  navbar Toggle
       -----------------------------------------------------------------------*/

  jQuery(".close-toggle").on("click", function () {
    jQuery(".h-collapse.navbar-collapse").collapse("hide");
  });

  /*---------------------------------------------------------------------
        Mailbox
        -----------------------------------------------------------------------*/
  jQuery(document).on("click", "ul.iq-email-sender-list li", function () {
    jQuery(this).next().addClass("show");
    // jQuery('.mail-box-detail').css('filter','blur(4px)');
  });

  jQuery(document).on("click", ".email-app-details li h4", function () {
    jQuery(".email-app-details").removeClass("show");
  });

  /*---------------------------------------------------------------------
        chatuser
        -----------------------------------------------------------------------*/
  jQuery(document).on("click", ".chat-head .chat-user-profile", function () {
    jQuery(this).parent().next().toggleClass("show");
  });
  jQuery(document).on("click", ".user-profile .close-popup", function () {
    jQuery(this).parent().parent().removeClass("show");
  });

  /*---------------------------------------------------------------------
        chatuser main
        -----------------------------------------------------------------------*/
  jQuery(document).on("click", ".chat-search .chat-profile", function () {
    jQuery(this).parent().next().toggleClass("show");
  });
  jQuery(document).on("click", ".user-profile .close-popup", function () {
    jQuery(this).parent().parent().removeClass("show");
  });

  /*---------------------------------------------------------------------
        Chat start
        -----------------------------------------------------------------------*/
  jQuery(document).on("click", "#chat-start", function () {
    jQuery(".chat-data-left").toggleClass("show");
  });
  jQuery(document).on("click", ".close-btn-res", function () {
    jQuery(".chat-data-left").removeClass("show");
  });
  jQuery(document).on("click", ".iq-chat-ui li", function () {
    jQuery(".chat-data-left").removeClass("show");
  });
  jQuery(document).on("click", ".sidebar-toggle", function () {
    jQuery(".chat-data-left").addClass("show");
  });

  /*---------------------------------------------------------------------
        todo Page
        -----------------------------------------------------------------------*/
  jQuery(document).on("click", ".todo-task-list > li > a", function () {
    jQuery(".todo-task-list li").removeClass("active");
    jQuery(".todo-task-list .sub-task").removeClass("show");
    jQuery(this).parent().toggleClass("active");
    jQuery(this).next().toggleClass("show");
  });
  jQuery(document).on("click", ".todo-task-list > li li > a", function () {
    jQuery(".todo-task-list li li").removeClass("active");
    jQuery(this).parent().toggleClass("active");
  });

  /*---------------------------------------------------------------------
        user toggle
        -----------------------------------------------------------------------*/
  jQuery(document).on("click", ".iq-user-toggle", function () {
    jQuery(this).parent().addClass("show-data");
  });

  jQuery(document).on("click", ".close-data", function () {
    jQuery(".iq-user-toggle").parent().removeClass("show-data");
  });
  jQuery(document).on("click", function (event) {
    var $trigger = jQuery(".iq-user-toggle");
    if ($trigger !== event.target && !$trigger.has(event.target).length) {
      jQuery(".iq-user-toggle").parent().removeClass("show-data");
    }
  });
  /*-------hide profile when scrolling--------*/
  jQuery(window).scroll(function () {
    let scroll = jQuery(window).scrollTop();
    if (
      scroll >= 10 &&
      jQuery(".iq-user-toggle").parent().hasClass("show-data")
    ) {
      jQuery(".iq-user-toggle").parent().removeClass("show-data");
    }
  });
  let Scrollbar = window.Scrollbar;
  if (jQuery(".data-scrollbar").length) {
    Scrollbar.init(document.querySelector(".data-scrollbar"), {
      continuousScrolling: false,
    });
  }

    /*---------------------------------------------------------------------
        Datatables
    -----------------------------------------------------------------------*/
    if(jQuery('.data-tables').length)
    {
      $('.data-tables').DataTable();
    }

  /*---------------------------------------------------------------------
        Form Validation
        -----------------------------------------------------------------------*/

  // Example starter JavaScript for disabling form submissions if there are invalid fields
  window.addEventListener(
    "load",
    function () {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName("needs-validation");
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function (form) {
        form.addEventListener(
          "submit",
          function (event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add("was-validated");
          },
          false
        );
      });
    },
    false
  );

  /*---------------------------------------------------------------------
       Active Class for Pricing Table
       -----------------------------------------------------------------------*/
  jQuery("#my-table tr th").click(function () {
    jQuery("#my-table tr th").children().removeClass("active");
    jQuery(this).children().addClass("active");
    jQuery("#my-table td").each(function () {
      if (jQuery(this).hasClass("active")) {
        jQuery(this).removeClass("active");
      }
    });
    var col = jQuery(this).index();
    jQuery("#my-table tr td:nth-child(" + parseInt(col + 1) + ")").addClass(
      "active"
    );
  });

  /*------------------------------------------------------------------
        Select 2 Selectpicker
        * -----------------------------------------------------------------*/

  if ($.fn.select2 !== undefined) {
    $("#single").select2({
      placeholder: "Select a Option",
      allowClear: true,
    });
    $("#multiple").select2({
      placeholder: "Select a Multiple Option",
      allowClear: true,
    });
    $("#multiple2").select2({
      placeholder: "Select a Multiple Option",
      allowClear: true,
    });
  }

  /*------------------------------------------------------------------
        Flatpicker
        * -----------------------------------------------------------------*/
  if (jQuery.fn.flatpickr !== undefined) {
    if (jQuery(".basicFlatpickr").length > 0) {
      jQuery(".basicFlatpickr").flatpickr();
    }

    if (jQuery("#inputTime").length > 0) {
      jQuery("#inputTime").flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
      });
    }
    if (jQuery("#inputDatetime").length > 0) {
      jQuery("#inputDatetime").flatpickr({
        enableTime: true,
      });
    }
    if (jQuery("#inputWeek").length > 0) {
      jQuery("#inputWeek").flatpickr({
        weekNumbers: true,
      });
    }
    if (jQuery("#inline-date").length > 0) {
      jQuery("#inline-date").flatpickr({
        inline: true,
      });
    }
    if (jQuery("#inline-date1").length > 0) {
      jQuery("#inline-date1").flatpickr({
        inline: true,
      });
    }
  }

  /*---------------------------------------------------------------------
        Scrollbar
        -----------------------------------------------------------------------*/

  jQuery(window)
    .on("resize", function () {
      if (jQuery(this).width() <= 1299) {
        jQuery("#salon-scrollbar").addClass("data-scrollbar");
      } else {
        jQuery("#salon-scrollbar").removeClass("data-scrollbar");
      }
    })
    .trigger("resize");

  jQuery(".data-scrollbar").each(function () {
    var attr = $(this).attr("data-scroll");
    if (typeof attr !== typeof undefined && attr !== false) {
      let Scrollbar = window.Scrollbar;
      var a = jQuery(this).data("scroll");
      Scrollbar.init(document.querySelector('div[data-scroll= "' + a + '"]'));
    }
  });

  /*---------------------------------------------------------------------
        Pricing tab
        -----------------------------------------------------------------------*/
  jQuery(window).on("scroll", function (e) {
    // Pricing Pill Tab
    var nav = jQuery("#pricing-pills-tab");
    if (nav.length) {
      var contentNav = nav.offset().top - window.outerHeight;
      if (jQuery(window).scrollTop() >= contentNav) {
        e.preventDefault();
        jQuery("#pricing-pills-tab li a").removeClass("active");
        jQuery("#pricing-pills-tab li a[aria-selected=true]").addClass(
          "active"
        );
      }
    }
  });

  /*---------------------------------------------------------------------
        Sweet alt Delete
        -----------------------------------------------------------------------*/
  $('[data-extra-toggle="delete"]').on("click", function (e) {
    const closestElem = $(this).attr("data-closest-elem");
    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: "btn btn-primary",
        cancelButton: "btn btn-outline-primary ml-2",
      },
      buttonsStyling: false,
    });

    swalWithBootstrapButtons
      .fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        showClass: {
          popup: "animate__animated animate__zoomIn",
        },
        hideClass: {
          popup: "animate__animated animate__zoomOut",
        },
      })
      .then((willDelete) => {
        if (willDelete.isConfirmed) {
          swalWithBootstrapButtons
            .fire({
              title: "Deleted!",
              text: "Your note has been deleted.",
              icon: "success",
              showClass: {
                popup: "animate__animated animate__zoomIn",
              },
              hideClass: {
                popup: "animate__animated animate__zoomOut",
              },
            })
            .then(() => {
              if (closestElem == ".card") {
                $(this).closest(closestElem).parent().remove();
              } else {
                $(this).closest(closestElem).remove();
              }
            });
        } else {
          swalWithBootstrapButtons.fire({
            title: "Your note is safe!",
            showClass: {
              popup: "animate__animated animate__zoomIn",
            },
            hideClass: {
              popup: "animate__animated animate__zoomOut",
            },
          });
        }
      });
  });

  if ($.fn.slick !== undefined && $(".top-product").length > 0) {
    jQuery(".top-product").slick({
      slidesToShow: 3,
      speed: 300,
      slidesToScroll: 1,
      focusOnSelect: true,
      autoplay: true,
      arrows: false,
      responsive: [
        {
          breakpoint: 768,
          settings: {
            arrows: false,
            slidesToShow: 2,
          },
        },
        {
          breakpoint: 480,
          settings: {
            arrows: false,
            autoplay: true,
            slidesToShow: 1,
          },
        },
      ],
    });
  }
})(jQuery);


if ($(".edit-menu-container").length) {
// Track the number of forms
let formCount = 1; 

const showFormButton = document.getElementById('showFormButton');
const formContainer = document.getElementById('formContainer');

var deleteRoleMenu = document.querySelectorAll(".deleteButton");

if(deleteRoleMenu){

deleteRoleMenu.forEach(function (deleteButton) {
deleteButton.addEventListener("click", function () {
  var id_menu = deleteButton.getAttribute("role-menu-id");

  var url ="delete_menu";
  var xhr = new XMLHttpRequest();
  var data = {
    id : id_menu
  };

  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-Type", "application/json");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
          try{
            var response = JSON.parse(xhr.responseText);
            if(response.message === "Data Terhapus"){
              alert('Data Telah Terhapus')
              location.reload(true);
            }else{
              alert('Data Gagal Terhapus')
              location.reload(true);
            }
          }catch(error){
            console.log("Terjadi Kesalahan parsing JSON:", error);
          }

         }

       }

  } 

    // Kirim permintaan
    xhr.send(JSON.stringify(data));


});
});

};




showFormButton.addEventListener('click', (event) => {
  event.preventDefault;
  var role_id = showFormButton.getAttribute("role-id");
    // var role_id = showFormButton.getAttribute("data-role-id");
   

    var url ="list_menu_all";
    var xhr = new XMLHttpRequest();

    // Konfigurasi permintaan
    xhr.open("GET", url, true);
    xhr.setRequestHeader("Content-Type", "application/json");

    // Definisikan fungsi panggilan kembali
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          try {
            var response = JSON.parse(xhr.responseText);
            if(response.message === "found"){

              var all_menu = response.list_menu;
            
                const optionsHTML = all_menu.map(list_menu => `
                    <option value="${list_menu.nav_id}">${list_menu.nav_title}</option>
                  `).join('');
        
              const formWrapper = document.createElement('div');
              formWrapper.classList.add('formWrapper');
              formWrapper.id = 'form_ '+ formCount;
          
              formWrapper.innerHTML = `
                                <input type="hidden" class="form-control" value="${role_id}" name="role_id[]">
                                  <div class="col-md-8">
                                      <div class="form-group">
                                          <label for="userType">Akses Menu</label>
                                          <select id="list_menu" name="akses_menu[]" class="form-control">
                                              ${optionsHTML}
                                          </select>
                                      </div>
                                  </div>
 
                                <div class="row" style="margin-top: 10px;">
                                    <div class="col">
                                        <select class="form-control" name="read[]">
                                            <option value="1">Allowed</option>
                                            <option value="0">Not Allowed</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <select class="form-control" name="create[]">
                                            <option value="1">Allowed</option>
                                            <option value="0">Not Allowed</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <select class="form-control" name="edit[]">
                                            <option value="1">Allowed</option>
                                            <option value="0">Not Allowed</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <select class="form-control" name="delete[]">
                                            <option value="1">Allowed</option>
                                            <option value="0">Not Allowed</option>
                                        </select>
                                    </div>
                                </div>  
                   `;
          
              formCount++;
              formContainer.appendChild(formWrapper);
            }else{
              console.log(response.message);
            }
          } catch (error){
            console.log("Terjadi Kesalahan parsing JSON:", error);
          }
        }else{
          console.log("Terjadi kesalahan HTTP");
        }
      }
    };

    // Kirim permintaan
    xhr.send(JSON.stringify());
   
    

   
});

};




