function mylicensekey() {
    var license_key_change = $("#field-settings_license_key").val();
    var server_name = window.location.hostname;

    var license_key_valid = null;
    async function licenseKey() {
        var formdata = new FormData();
        formdata.append("token", license_key_change);
        formdata.append("SERVER_NAME", "classiconline2.bitrix24.shop");

        var requestOptions = {
            method: 'POST',
            body: formdata,
        };

        let response_v = await fetch("https://www.skynettechnologies.com/add-ons/license-api.php", requestOptions)
        return await response_v.json();
    }
    licenseKey().then(function (locale) {
        license_key_valid = locale.valid;
        if (license_key_valid == 1) {
            document.getElementById("icon_type").style.display = "";
            document.getElementById("icon_size").style.display = "";
            document.getElementById("license_key_msg").style.display = "none";
            document.getElementById("invalid_key_msg").style.display = "none";
            // document.getElementById("discount_banner").style.display = "none";

        }
        else {
            // setCouponBanner();
            document.getElementById("icon_type").style.display = "none";
            document.getElementById("icon_size").style.display = "none";
            document.getElementById("invalid_key_msg").style.display = "";
            document.getElementById("license_key_msg").style.display = "";
            // document.getElementById("discount_banner").style.display = "";

        }
        if (license_key_change == '') {
            // document.getElementById("icon_type").style.display = "none";
            // document.getElementById("icon_size").style.display = "none";
            document.getElementById("invalid_key_msg").style.display = "none";
        }
    });
}

setTimeout(function() {
    var x = document.getElementsByClassName("admin__header--title")[0];
    x.id="menu"
    document.getElementById("menu").style.display = "none";
    // var hide_ada_label = document.getElementById("hide_bar").style.display = "none";
    var license_key_check = document.querySelector('input[name="field-settings_license_key"]').value;
    console.log("Checking_js file",x);
    mylicensekey(license_key_check);
    if (license_key_check !== "") {
        document.getElementById("icon_type").style.display = "";
        document.getElementById("icon_size").style.display = "";
        document.getElementById("license_key_msg").style.display = "none";
    }
    else {
        document.getElementById("icon_type").style.display = "none";
        document.getElementById("icon_size").style.display = "none";
    }
    // if (license_key_check !== "ADAAIOA-FD8BCB9FDC14475BF7B0AB75BBE54FA1") {
    //     document.getElementById("license_key_message").style.display = "";
    //     document.getElementById("license_key_msg").style.display = "";
    //     document.getElementById("icon_type").style.display = "none";
    //     document.getElementById("icon_size").style.display = "none";
    // }
    // var selected = document.querySelector('input[type=radio][name="PL3bbeec384_aioa_icon_size"]:checked').value;
    var getSelectedValueaioa_icontype_value = document.querySelector('input[name="field-settings_allinoneaccessibility_icon_type"]:checked').value;
    //var resImage = getSelectedValueaioa_icontype_value.replace("_", "-");
    var resImage= getSelectedValueaioa_icontype_value.replace(new RegExp('_', 'g'), '-');
    var resImage= "https://www.skynettechnologies.com/sites/default/files/python/"+resImage+".svg";
    var aioa_big_icon_id=document.querySelector('input[name="field-settings_aioa_icon_size"][value="aioa-big-icon"]').id;
    document.querySelector('label[for="'+aioa_big_icon_id+'"]').innerHTML='<img src="'+resImage+'" alt="Big" title="Big" width="75" height="75" style="background-color:#6f42c1;border-radius:100%">';

    var aioa_medium_icon_id=document.querySelector('input[name="field-settings_aioa_icon_size"][value="aioa-medium-icon"]').id;
    document.querySelector('label[for="'+aioa_medium_icon_id+'"]').innerHTML='<img src="'+resImage+'" alt="Medium" title="Medium" width="65" height="65" style="background-color:#6f42c1;border-radius:100%">';

    var aioa_default_icon_id=document.querySelector('input[name="field-settings_aioa_icon_size"][value="aioa-default-icon"]').id;
    document.querySelector('label[for="'+aioa_default_icon_id+'"]').innerHTML='<img src="'+resImage+'" alt="Default" title="Default" width="55" height="55" style="background-color:#6f42c1;border-radius:100%">';

    var aioa_small_icon_id=document.querySelector('input[name="field-settings_aioa_icon_size"][value="aioa-small-icon"]').id;
    document.querySelector('label[for="'+aioa_small_icon_id+'"]').innerHTML='<img src="'+resImage+'" alt="Small" title="Small" width="45" height="45" style="background-color:#6f42c1;border-radius:100%">';

    var aioa_extra_small_icon_id=document.querySelector('input[name="field-settings_aioa_icon_size"][value="aioa-extra-small-icon"]').id;
    document.querySelector('label[for="'+aioa_extra_small_icon_id+'"]').innerHTML='<img src="'+resImage+'" alt="Extra Small" title="Extra Small" width="35" height="35" style="background-color:#6f42c1;border-radius:100%">';
},500);

// function setCouponBanner(){
//   var coupon_url = 'https://www.skynettechnologies.com/add-ons/discount_offer.php?platform=getgrav';
//   fetch(coupon_url)
//     .then(function (response) {
//       return response.text();
//     })
//     .then(function (body) {
//       document.getElementById("discount_banner").innerHTML(body);
//       // $("#dicount_banner").html(body);
//       var domain_name = window.location.origin
//     });
// }

setTimeout(() => {
    const sizeOptions = document.querySelectorAll('input[name="field-settings_aioa_icon_size"]').value;
    const sizeOptionsImg = document.querySelectorAll('input[name="field-settings_aioa_icon_size"] + label img');
    const typeOptions = document.querySelectorAll('input[name="field-settings_allinoneaccessibility_icon_type"]');
    typeOptions.forEach(option => {
        option.addEventListener("click", (event) => {
            sizeOptionsImg.forEach(option2 => {
                var ico_type = document.querySelector('input[name="field-settings_allinoneaccessibility_icon_type"]:checked').value;
                option2.setAttribute("src", "https://skynettechnologies.com/sites/default/files/python/" + ico_type + ".svg");
            });
        });
    });
},500);
