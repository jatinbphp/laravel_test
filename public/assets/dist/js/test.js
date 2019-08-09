jQuery(document).ready(function() {
    messsage = "Your change is being processed. It may take up to 15 minutes to take effect.";
    //basic
    var slideToTop = jQuery("<div />");
    slideToTop.html('<i class="fa fa-chevron-up"></i>');
    slideToTop.css({
        position: 'fixed',
        bottom: '20px',
        right: '25px',
        width: '40px',
        height: '40px',
        color: '#eee',
        'font-size': '',
        'line-height': '40px',
        'text-align': 'center',
        'background-color': '#222d32',
        cursor: 'pointer',
        'border-radius': '5px',
        'z-index': '99999',
        opacity: '.7',
        'display': 'none'
    });
    slideToTop.on('mouseenter', function() {
        jQuery(this).css('opacity', '1');
    });
    slideToTop.on('mouseout', function() {
        jQuery(this).css('opacity', '.7');
    });
    jQuery('.wrapper').append(slideToTop);
    jQuery(window).scroll(function() {
        if (jQuery(window).scrollTop() >= 150) {
            if (!jQuery(slideToTop).is(':visible')) {
                jQuery(slideToTop).fadeIn(500);
            }
        } else {
            jQuery(slideToTop).fadeOut(500);
        }
    });
    jQuery(slideToTop).click(function() {
        jQuery("body").animate({
            scrollTop: 0
        }, 500);
    });
    jQuery(".sidebar-menu li:not(.treeview) a").click(function() {
        var jQuerythis = jQuery(this);
        var target = jQuerythis.attr("href");
        if (typeof target === 'string') {
            jQuery("body").animate({
                scrollTop: (jQuery(target).offset().top) + "px"
            }, 500);
        }
    });
    jQuery(".dateTimePicker").datetimepicker({
        datepicker: true,
        format: 'm/d/Y H:i',
        step: 5
    });
    jQuery.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="_token"]').attr('content')
        }
    });
    String.prototype.replaceAll = function(search, replacement) {
        var target = this;
        return target.replace(new RegExp(search, 'g'), replacement);
    };
    jQuery.ajaxSetup({
        statusCode: {
            401: function() {
                swal({
                    title: "Session Timeout",
                    type: "error",
                    timer: 2000,
                    showConfirmButton: false
                });
                location.reload();
            }
        }
    });
    
    jQuery(".select2").select2();
    
    /* ----------------------------------------------------------------------- */
    //validation for numeric value 
    jQuery(".numeric").keydown(function(e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if (jQuery.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    /**
     * 
     * @param  {[type]} ) {                   deleteId [description]
     * @return {[type]}   [description]
     */
    jQuery(document).on("click", ".btn-delete", function() {
        deleteId = jQuery(this).data('id');
        type = jQuery(this).data('type');
        name = jQuery(this).data('name');
        
        if (deleteId == undefined) {
            var deleteElement = jQuery('#' + type + ' tbody input[type=checkbox]:checked');
            var deleteId = [];
            jQuery.each(deleteElement, function(i, ele) {
                deleteId.push(jQuery(ele).val());
            });
        } else {
            deleteId = [deleteId];
        }

        if (0 == deleteId) {
            swal({
                title: "please select a record to proceed",
                type: "warning",
                timer: 3000,
                showConfirmButton: true
            });
            return false;
        } else {
            jQuery('#confirmDelete .modal-title').html('Delete ' + type);
            jQuery('#confirmDelete .modal-body p').html('Are you sure you want to delete this ' + name + " " + type + ' ?');
            jQuery('#confirmDelete .model_click').attr('data-value', deleteId);
            jQuery('#confirmDelete .model_click').attr('data-type', type);
            jQuery('#confirmDelete .model_click').addClass('model_click_master');
            jQuery('#confirmDelete').modal('show');
            jQuery(".clearText").text("");
        }
    });

    /**
     * [deleteData description]
     * @param  {[type]} tpye     [description]
     * @param  {[type]} deleteId [description]
     * @return {[type]}          [description]
     */
    function deleteData(tpye, deleteId) {
        jQuery.ajax({
            url: public_path + type + "/delete",
            type: 'delete',
            dataType: 'json',
            data: {
                id: deleteId,
            },
            beforeSend: function() {
                myShow();
                jQuery('#replaceConfirm').modal('hide');
                jQuery('#confirmDelete').modal('hide');
            },
            complete: function() {
                myHide();
            },
            success: function(respObj) {
                jQuery('#messsage').find("p").removeClass("callout-danger callout-success");
                if (respObj.success) {
                    jQuery('#messsage').find("p").addClass('callout callout-success').html(type + " Deleted Successfully .").show().delay(3000).fadeOut('slow');
                    
                    if(type == 'rules') {
                        jQuery(".ruleHtmlList").html(respObj.html);
                    }

                    if(type == "category_rules_delete") {
                        jQuery("#typesCategoryId").trigger("change");   
                        jQuery(".categoryRuleHtmlList").html(respObj.html);
                    }

                    if(type == "category_rules") {
                        jQuery("#typesCategoryId").trigger("change");   
                        jQuery(".categoryRuleHtmlList").html(respObj.html);
                    }
                } else {
                    jQuery('#messsage').find("p").addClass('callout callout-danger').html(respObj.message).show().delay(5000).fadeOut('slow');
                }
            },
        });
    }
    
    /**
     * [description]
     * @param  {[type]} ) {               } [description]
     * @return {[type]}   [description]
     */
    jQuery(document).on("click", ".model_click_master", function() {
        var deleteId = jQuery(this).attr('data-value');
        var type = jQuery(this).attr('data-type');
        deleteData(type, deleteId);
    });
    
    /**
     * [description]
     * @param  {[type]} ) {               } [description]
     * @return {[type]}   [description]
     */
    jQuery(document).on("click", ".btnRuleSave", function(e) {
        var data = jQuery("#rules_frm").serialize();
        jQuery.ajax({
            url: public_path +"rules/save",
            type: 'post',
            dataType: 'json',
            data: data,
            beforeSend: function() {
                myShow();
            },
            complete: function() {
                myHide();
            },
            error: function(respObj) {
                jQuery('#messsage').find("p").removeClass("callout-danger callout-success");
                if (respObj.status == 400) {
                    jQuery.each(respObj.responseJSON.errors, function(k, v) {
                        jQuery('.box-body #' + k + '_error').text("");
                        jQuery('.box-body #' + k + '_error').text(v);
                    });
                }
            },
            success: function(respObj) {
                jQuery('#messsage').find("p").removeClass("callout-danger callout-success");
                if (respObj.success) {
                    jQuery('#messsage').find("p").addClass('callout callout-success').html("Rules Data Save Successfully").show().delay(3000).fadeOut('slow');
                    jQuery(".box-body #name_error").text("");                    
                    jQuery(".box-body #description_error").text("");                   
                    jQuery(".ruleHtmlList").html(respObj.html);
                    jQuery("#rules_frm")[0].reset();
                    jQuery('#typesCategoryRulesId').find('option').not(':first').remove();
                    jQuery.each(respObj.ruleList, function(i, item) {
                        jQuery('#typesCategoryRulesId').append(jQuery('<option>', {
                            value: i,
                            text: item
                        }));
                    });
                }
            },
        });
        return false;
    });

    /**
     * [description]
     * @param  {[type]} ) {               } [description]
     * @return {[type]}   [description]
     */
    jQuery(document).on("click", ".btnRuleEdit", function(e) {
        e.preventDefault();
        var id = jQuery(this).data("id");

        jQuery.ajax({
            url: public_path +"rules/get/"+id,
            type: 'get',
            dataType: 'json',
            beforeSend: function() {
                myShow();
            },
            complete: function() {
                myHide();
            },
            error: function(respObj) {
                jQuery('#messsage').find("p").removeClass("callout-danger callout-success");
                if (respObj.status == 400) {
                    jQuery.each(respObj.responseJSON.errors, function(k, v) {
                        jQuery('.box-body #' + k + '_error').text("");
                        jQuery('.box-body #' + k + '_error').text(v);
                    });
                }
            },
            success: function(respObj) {
                jQuery('#messsage').find("p").removeClass("callout-danger callout-success");
                if (respObj.success) {
                    jQuery(".rulesName").val(respObj.rules.name);
                    jQuery(".rulesAction").val("edit");
                    jQuery(".rulesId").val(respObj.rules.id);
                    jQuery(".rulesDescription").val(respObj.rules.description);
                    jQuery(".clearText").text("");
                }
            },
        });
    });

    /**
     * [description]
     * @param  {[type]} ) {               } [description]
     * @return {[type]}   [description]
     */
    jQuery(document).on("input", ".countryName", function(e) {
        jQuery(".countrySave,.countryUpdate,.countryDelete").addClass("hide");
        if(jQuery(".countryName").val().length > 0 && jQuery("#countryId").val() == "") {
            jQuery(".countrySave").removeClass("hide");
        } else if(jQuery(".countryName").val().length > 0 && jQuery("#countryId").val() != "") {
            jQuery(".countryUpdate").removeClass("hide");
        } else if(jQuery("#countryId").val() != "") {
            jQuery(".countryDelete").removeClass("hide");
        }
    });

    /**
     * [description]
     * @param  {[type]} ) {               } [description]
     * @return {[type]}   [description]
     */
    jQuery(document).on("input", ".typeName", function(e) {
        jQuery(".typeSave,.typeUpdate,.typeDelete").addClass("hide");
        if(jQuery(".typeName").val().length > 0 && jQuery("#typeId").val() == "") {
            jQuery(".typeSave").removeClass("hide");
        } else if(jQuery(".typeName").val().length > 0 && jQuery("#typeId").val() != "") {
            jQuery(".typeUpdate").removeClass("hide");
        } else if(jQuery("#typeId").val() != "") {
            jQuery(".typeDelete").removeClass("hide");
        }
    });

    /**
     * [description]
     * @param  {[type]} ) {               } [description]
     * @return {[type]}   [description]
     */
    jQuery(document).on("input", ".typeCategoryName", function(e) {
        jQuery(".typeCategorySave,.typeCategoryUpdate,.typeCategoryDelete").addClass("hide");
        if(jQuery(".typeCategoryName").val().length > 0 && jQuery("#typesCategoryId").val() == "") {
            jQuery(".typeCategorySave").removeClass("hide");
        } else if(jQuery(".typeCategoryName").val().length > 0 && jQuery("#typesCategoryId").val() != "") {
            jQuery(".typeCategoryUpdate").removeClass("hide");
        } else if(jQuery("#typesCategoryId").val() != "") {
            jQuery(".typeCategoryDelete").removeClass("hide");
        }
    });

    /**
     * [description]
     * @param  {[type]} ) {               } [description]
     * @return {[type]}   [description]
     */
    jQuery(document).on("click", ".btnCountrySave", function(e) {
        var data = jQuery(".countryName").val();
        jQuery.ajax({
            url: public_path +"country/save",
            type: 'post',
            dataType: 'json',
            data: {
                "country_name": data,
            },
            beforeSend: function() {
                myShow();
            },
            complete: function() {
                myHide();
            },
            error: function(respObj) {
                jQuery('#messsage').find("p").removeClass("callout-danger callout-success");
                if (respObj.status == 400) {
                    jQuery.each(respObj.responseJSON.errors, function(k, v) {
                        jQuery('.box-body #' + k + '_error').text("");
                        jQuery('.box-body #' + k + '_error').text(v);
                    });
                }
            },
            success: function(respObj) {
                jQuery('#messsage').find("p").removeClass("callout-danger callout-success");
                if (respObj.success) {
                    jQuery('#countryId').find('option').not(':first').remove();
                    jQuery('#messsage').find("p").addClass('callout callout-success').html("Country Data Save Successfully").show().delay(3000).fadeOut('slow');
                    jQuery(".countryName").val("");
                    jQuery(".countrySave").addClass("hide");
                    jQuery.each(respObj.countries, function(i, item) {
                        jQuery('#countryId').append(jQuery('<option>', {
                            value: i,
                            text: item
                        }));
                    });
                    jQuery(".clearText").text("");
                }
            },
        });
        return false;
    });

    /**
     * [description]
     * @param  {[type]} ) {               } [description]
     * @return {[type]}   [description]
     */
    jQuery(document).on("click", ".btnTypeSave", function(e) {
        var countryId = jQuery("#countryId").val();
        var data = jQuery(".typeName").val();
        jQuery.ajax({
            url: public_path +"types/save",
            type: 'post',
            dataType: 'json',
            data: {
                "type_name": data,
                "country_id":countryId
            },
            beforeSend: function() {
                myShow();
            },
            complete: function() {
                myHide();
            },
            error: function(respObj) {
                jQuery('#messsage').find("p").removeClass("callout-danger callout-success");
                if (respObj.status == 400) {
                    jQuery.each(respObj.responseJSON.errors, function(k, v) {
                        jQuery('.box-body #' + k + '_error').text("");
                        jQuery('.box-body #' + k + '_error').text(v);
                    });
                }
            },
            success: function(respObj) {
                jQuery('#messsage').find("p").removeClass("callout-danger callout-success");
                if (respObj.success) {
                    jQuery('#typeId').find('option').not(':first').remove();
                    jQuery('#messsage').find("p").addClass('callout callout-success').html("Type Data Save Successfully").show().delay(3000).fadeOut('slow');
                    jQuery(".typeName").val("");
                    jQuery(".typeSave").addClass("hide");
                    jQuery.each(respObj.types, function(i, item) {
                        jQuery('#typeId').append(jQuery('<option>', {
                            value: i,
                            text: item
                        }));
                    });
                    jQuery(".clearText").text("");
                }
            },
        });
        return false;
    });

    /**
     * [description]
     * @param  {[type]} ) {               } [description]
     * @return {[type]}   [description]
     */
    jQuery(document).on("click", ".btnTypeCategorySave", function(e) {
        var countryId = jQuery("#countryId").val();
        var typeId = jQuery("#typeId").val();
        var data = jQuery(".typeCategoryName").val();
        jQuery.ajax({
            url: public_path +"types_category/save",
            type: 'post',
            dataType: 'json',
            data: {
                "types_category_name": data,
                "country_id":countryId,
                "type_id":typeId
            },
            beforeSend: function() {
                myShow();
            },
            complete: function() {
                myHide();
            },
            error: function(respObj) {
                jQuery('#messsage').find("p").removeClass("callout-danger callout-success");
                if (respObj.status == 400) {
                    jQuery.each(respObj.responseJSON.errors, function(k, v) {
                        jQuery('.box-body #' + k + '_error').text("");
                        jQuery('.box-body #' + k + '_error').text(v);
                    });
                }
            },
            success: function(respObj) {
                jQuery('#messsage').find("p").removeClass("callout-danger callout-success");
                if (respObj.success) {
                    jQuery('#typesCategoryId').find('option').not(':first').remove();
                    jQuery('#messsage').find("p").addClass('callout callout-success').html("Country Type Data Save Successfully").show().delay(3000).fadeOut('slow');
                    jQuery(".typeCategoryName").val("");
                    jQuery(".typeCategorySave").addClass("hide");
                    jQuery.each(respObj.types_category, function(i, item) {
                        jQuery('#typesCategoryId').append(jQuery('<option>', {
                            value: i,
                            text: item
                        }));
                    });
                    jQuery(".clearText").text("");
                }
            },
        });
        return false;
    });

    /**
     * [description]
     * @param  {[type]} ) {               } [description]
     * @return {[type]}   [description]
     */
    jQuery(document).on("click", ".btnTypeCategoryRulesSave", function(e) {
        var countryId = jQuery("#countryId").val();
        var typeId = jQuery("#typeId").val();
        var typeCategoryId = jQuery("#typesCategoryId").val();
        var typeCategoryRulesId = jQuery("#typesCategoryRulesId").val();

        jQuery.ajax({
            url: public_path +"types_category_rules/save",
            type: 'post',
            dataType: 'json',
            data: {
                "country_id":countryId,
                "type_id":typeId,
                "type_category_id":typeCategoryId,
                "rules_id":typeCategoryRulesId,
            },
            beforeSend: function() {
                myShow();
            },
            complete: function() {
                myHide();
            },
            error: function(respObj) {
                jQuery('#messsage').find("p").removeClass("callout-danger callout-success");
                if (respObj.status == 400) {
                    jQuery.each(respObj.responseJSON.errors, function(k, v) {
                        jQuery('.box-body #' + k + '_error').text("");
                        jQuery('.box-body #' + k + '_error').text(v);
                    });
                }
            },
            success: function(respObj) {
                jQuery('#messsage').find("p").removeClass("callout-danger callout-success");
                if (respObj.success) {
                    jQuery(".rulesListHtml").html("");
                    jQuery(".typeCategoryRulesUpdate").addClass("hide");
                    jQuery(".categoryRuleHtmlList").html(respObj.html);
                    jQuery("#typesCategoryId").trigger("change");
                    jQuery(".clearText").text("");
                }
            },
        });
        return false;
    });

    /**
     * [description]
     * @param  {[type]} )        {                      var countryId [description]
     * @param  {[type]} success: function(html) {                                             jQuery.each(html, function(i, item) {                        jQuery('#typeId').append(jQuery('<option>', {                            value: i,                            text: item                        }));                    });                }            });            jQuery(".countrySave,.countryUpdate,.countryDelete").addClass("hide");            jQuery(".countryDelete").removeClass("hide");        } else {            jQuery(".countrySave,.countryUpdate,.countryDelete").addClass("hide" [description]
     * @return {[type]}          [description]
     */
    jQuery(document).on('change',"#countryId", function() {
        var countryId = jQuery(this).val();
        jQuery(".rulesListHtml").html("");
        jQuery('#typeId').find('option').not(':first').remove();
        if (countryId != "") {
            jQuery.ajax({
                type: 'GET',
                url: public_path + "gettype",
                data: {
                    'countryId': countryId,
                },
                success: function(html) {
                    jQuery.each(html, function(i, item) {
                        jQuery('#typeId').append(jQuery('<option>', {
                            value: i,
                            text: item
                        }));
                    });
                }
            });
            jQuery(".countrySave,.countryUpdate,.countryDelete").addClass("hide");
            jQuery(".countryDelete").removeClass("hide");
        } else {
            jQuery(".countrySave,.countryUpdate,.countryDelete").addClass("hide");
        }
    });

    /**
     * [description]
     * @param  {[type]} )        {                      var typeId [description]
     * @param  {[type]} success: function(html) {                                          jQuery.each(html, function(i, item) {                        jQuery('#typesCategoryId').append(jQuery('<option>', {                            value: i,                            text: item                        }));                    });                }            });        }    } [description]
     * @return {[type]}          [description]
     */
    jQuery(document).on('change',"#typeId", function() {
        var typeId = jQuery(this).val();
        jQuery(".rulesListHtml").html("");
        jQuery('#typesCategoryId').find('option').not(':first').remove();
        if (typeId != "") {
            jQuery.ajax({
                type: 'GET',
                url: public_path + "get_type_category",
                data: {
                    'typeId': typeId,
                },
                success: function(html) {
                    jQuery.each(html, function(i, item) {
                        jQuery('#typesCategoryId').append(jQuery('<option>', {
                            value: i,
                            text: item
                        }));
                    });
                }
            });
            jQuery(".typeSave,.typeUpdate,.typeDelete").addClass("hide");
            jQuery(".typeDelete").removeClass("hide");
        } else {
            jQuery(".typeSave,.typeUpdate,.typeDelete").addClass("hide");
        } 
    });

    /**
     * [description]
     * @param  {[type]} ) {                   var typesCategoryRulesId [description]
     * @return {[type]}   [description]
     */
    jQuery(document).on('change',"#typesCategoryId", function() {
        var typesCategoryId = jQuery(this).val();
        jQuery(".rulesListHtml").html("");
        if (typesCategoryId != "") {
            jQuery.ajax({
                type: 'GET',
                url: public_path + "get_rule_category",
                data: {
                    'typesCategoryId': typesCategoryId,
                },
                success: function(respObj) {
                    if (respObj.success) {
                        jQuery(".rulesListHtml").html(respObj.html);
                    }
                }
            });
            jQuery(".typeCategorySave,.typeCategoryUpdate,.typeCategoryDelete").addClass("hide");
            jQuery(".typeCategoryDelete").removeClass("hide");
        } else {
            jQuery(".typeCategorySave,.typeCategoryUpdate,.typeCategoryDelete").addClass("hide");
        }
    });

    /**
     * [description]
     * @param  {[type]} ) {                   var typesCategoryRulesId [description]
     * @return {[type]}   [description]
     */
    jQuery(document).on('change',"#typesCategoryRulesId", function() {
        var typesCategoryRulesId = jQuery(this).val();
        var rulesId = jQuery(".ruleUpdateId").val();
        if (typeId != "" && rulesId !="") {
            jQuery(".typeCategoryRulesUpdate").removeClass("hide");
        } else if (typeId != "" && rulesId =="") {
            jQuery(".typeCategoryRulesSave").removeClass("hide");
        } else {
            jQuery(".typeCategoryRulesSave").addClass("hide");
        }
    });

    /**
     * [description]
     * @param  {[type]} ) {               } [description]
     * @return {[type]}   [description]
     */
    jQuery(document).on("click", ".btnCountryDelete", function(e) {
        var countryId = jQuery("#countryId").val();
        
        if (countryId != "") {
            jQuery.ajax({
                url: public_path +"country/delete",
                type: 'post',
                dataType: 'json',
                data: {
                    "id":countryId,
                },
                beforeSend: function() {
                    myShow();
                },
                complete: function() {
                    myHide();
                },
                error: function(respObj) {
                    jQuery('#messsage').find("p").removeClass("callout-danger callout-success");
                    if (respObj.status == 400) {
                        jQuery.each(respObj.responseJSON.errors, function(k, v) {
                            jQuery('.box-body #' + k + '_error').text("");
                            jQuery('.box-body #' + k + '_error').text(v);
                        });
                    }
                },
                success: function(respObj) {
                    jQuery('#messsage').find("p").removeClass("callout-danger callout-success");
                    if (respObj.success) {
                        jQuery('#countryId').find('option').not(':first').remove();
                        jQuery.each(respObj.countries, function(i, item) {
                            jQuery('#countryId').append(jQuery('<option>', {
                                value: i,
                                text: item
                            }));
                        });
                        jQuery(".clearText").text("");
                    }
                },
            });
            jQuery(".countrySave,.countryUpdate,.countryDelete").addClass("hide");
        }
        return false;
    });

    /**
     * [description]
     * @param  {[type]} ) {               } [description]
     * @return {[type]}   [description]
     */
    jQuery(document).on("click", ".btnCountryUpdate", function(e) {
        var countryId = jQuery("#countryId").val();
        var countryName = jQuery(".countryName").val();
        jQuery('#countryId').find('option').not(':first').remove();
        if (countryId != "") {
            jQuery.ajax({
                url: public_path +"country/update/"+countryId,
                type: 'post',
                dataType: 'json',
                data: {
                    "country_name":countryName,
                },
                beforeSend: function() {
                    myShow();
                },
                complete: function() {
                    myHide();
                },
                error: function(respObj) {
                    jQuery('#messsage').find("p").removeClass("callout-danger callout-success");
                    if (respObj.status == 400) {
                        jQuery.each(respObj.responseJSON.errors, function(k, v) {
                            jQuery('.box-body #' + k + '_error').text("");
                            jQuery('.box-body #' + k + '_error').text(v);
                        });
                    }
                },
                success: function(respObj) {
                    jQuery('#messsage').find("p").removeClass("callout-danger callout-success");
                    if (respObj.success) {
                        jQuery.each(respObj.countries, function(i, item) {
                            jQuery('#countryId').append(jQuery('<option>', {
                                value: i,
                                text: item
                            }));
                        });
                        jQuery(".countryName").val("");
                        jQuery("#countryId").val(countryId);
                        jQuery(".clearText").text("");
                    }
                },
            });
            jQuery(".countrySave,.countryUpdate,.countryDelete").addClass("hide");
            jQuery(".countryDelete").removeClass("hide");
        }
        return false;
    });


    /**
     * [description]
     * @param  {[type]} ) {               } [description]
     * @return {[type]}   [description]
     */
    jQuery(document).on("click", ".btnTypeDelete", function(e) {
        var typeId = jQuery("#typeId").val();
        var countryId = jQuery("#countryId").val();
        jQuery('#typeId').find('option').not(':first').remove();
        if (typeId != "") {
            jQuery.ajax({
                url: public_path +"types/delete",
                type: 'post',
                dataType: 'json',
                data: {
                    "id":typeId,
                    "country_id":countryId
                },
                beforeSend: function() {
                    myShow();
                },
                complete: function() {
                    myHide();
                },
                error: function(respObj) {
                    jQuery('#messsage').find("p").removeClass("callout-danger callout-success");
                    if (respObj.status == 400) {
                        jQuery.each(respObj.responseJSON.errors, function(k, v) {
                            jQuery('.box-body #' + k + '_error').text("");
                            jQuery('.box-body #' + k + '_error').text(v);
                        });
                    }
                },
                success: function(respObj) {
                    jQuery('#messsage').find("p").removeClass("callout-danger callout-success");
                    if (respObj.success) {
                        jQuery.each(respObj.types, function(i, item) {
                            jQuery('#typeId').append(jQuery('<option>', {
                                value: i,
                                text: item
                            }));
                        });
                        jQuery(".clearText").text("");
                    }
                },
            });
            jQuery(".typeSave,.typeUpdate,.typeDelete").addClass("hide");
        }
        return false;
    });

    /**
     * [description]
     * @param  {[type]} ) {               } [description]
     * @return {[type]}   [description]
     */
    jQuery(document).on("click", ".btnTypeUpdate", function(e) {
        var countryId = jQuery("#countryId").val();
        var typeId = jQuery("#typeId").val();
        var typeName = jQuery(".typeName").val();
        jQuery('#typeId').find('option').not(':first').remove();
        if (countryId != "") {
            jQuery.ajax({
                url: public_path +"types/update/"+typeId,
                type: 'post',
                dataType: 'json',
                data: {
                    "type_name":typeName,
                    "country_id":countryId
                },
                beforeSend: function() {
                    myShow();
                },
                complete: function() {
                    myHide();
                },
                error: function(respObj) {
                    jQuery('#messsage').find("p").removeClass("callout-danger callout-success");
                    if (respObj.status == 400) {
                        jQuery.each(respObj.responseJSON.errors, function(k, v) {
                            jQuery('.box-body #' + k + '_error').text("");
                            jQuery('.box-body #' + k + '_error').text(v);
                        });
                    }
                },
                success: function(respObj) {
                    jQuery('#messsage').find("p").removeClass("callout-danger callout-success");
                    if (respObj.success) {
                        jQuery.each(respObj.types, function(i, item) {
                            jQuery('#typeId').append(jQuery('<option>', {
                                value: i,
                                text: item
                            }));
                        });
                        jQuery(".typeName").val("");
                        jQuery("#typeId").val(typeId);
                        jQuery(".clearText").text("");
                    }
                },
            });
            jQuery(".typeSave,.typeUpdate,.typeDelete").addClass("hide");
            jQuery(".typeDelete").removeClass("hide");
        }
        return false;
    });


    /**
     * [description]
     * @param  {[type]} ) {               } [description]
     * @return {[type]}   [description]
     */
    jQuery(document).on("click", ".btnTypeCategoryDelete", function(e) {
        var typeId = jQuery("#typeId").val();
        var countryId = jQuery("#countryId").val();
        var typesCategoryId = jQuery("#typesCategoryId").val();

        if (typesCategoryId != "") {
            jQuery.ajax({
                url: public_path +"types_category/delete",
                type: 'post',
                dataType: 'json',
                data: {
                    "id":typesCategoryId,
                    "type_id":typeId,
                    "country_id":countryId
                },
                beforeSend: function() {
                    myShow();
                },
                complete: function() {
                    myHide();
                },
                error: function(respObj) {
                    jQuery('#messsage').find("p").removeClass("callout-danger callout-success");
                    if (respObj.status == 400) {
                        jQuery.each(respObj.responseJSON.errors, function(k, v) {
                            jQuery('.box-body #' + k + '_error').text("");
                            jQuery('.box-body #' + k + '_error').text(v);
                        });
                    }
                },
                success: function(respObj) {
                    jQuery('#messsage').find("p").removeClass("callout-danger callout-success");
                    if (respObj.success) {
                        jQuery('#typesCategoryId').find('option').not(':first').remove();
                        jQuery.each(respObj.types_category, function(i, item) {
                            jQuery('#typesCategoryId').append(jQuery('<option>', {
                                value: i,
                                text: item
                            }));
                        });
                        jQuery(".clearText").text("");
                    }
                },
            });
            jQuery(".typeCategorySave,.typeCategoryUpdate,.typeCategoryDelete").addClass("hide");
        }
        return false;
    });

    /**
     * [description]
     * @param  {[type]} ) {               } [description]
     * @return {[type]}   [description]
     */
    jQuery(document).on("click", ".btnTypeCategoryUpdate", function(e) {
        var typeId = jQuery("#typeId").val();
        var countryId = jQuery("#countryId").val();
        var typesCategoryId = jQuery("#typesCategoryId").val();

        var typeCategoryName = jQuery(".typeCategoryName").val();
        jQuery('#typesCategoryId').find('option').not(':first').remove();
        if (typesCategoryId != "") {
            jQuery.ajax({
                url: public_path +"types_category/update/"+typeId,
                type: 'post',
                dataType: 'json',
                data: {
                    "type_category_name":typeCategoryName,
                    "type_id":typeId,
                    "country_id":countryId
                },
                beforeSend: function() {
                    myShow();
                },
                complete: function() {
                    myHide();
                },
                error: function(respObj) {
                    jQuery('#messsage').find("p").removeClass("callout-danger callout-success");
                    if (respObj.status == 400) {
                        jQuery.each(respObj.responseJSON.errors, function(k, v) {
                            jQuery('.box-body #' + k + '_error').text("");
                            jQuery('.box-body #' + k + '_error').text(v);
                        });
                    }
                },
                success: function(respObj) {
                    jQuery('#messsage').find("p").removeClass("callout-danger callout-success");
                    if (respObj.success) {
                        jQuery.each(respObj.types_category, function(i, item) {
                            jQuery('#typesCategoryId').append(jQuery('<option>', {
                                value: i,
                                text: item
                            }));
                        });
                        jQuery(".typeCategoryName").val("");
                        jQuery("#typesCategoryId").val(typesCategoryId);
                        jQuery(".clearText").text("");
                    }
                },
            });
            jQuery(".typeCategorySave,.typeCategoryUpdate,.typeCategoryDelete").addClass("hide");
            jQuery(".typeCategoryDelete").removeClass("hide");
        }
        return false;
    });

    /**
     * [description]
     * @param  {[type]} ) {               } [description]
     * @return {[type]}   [description]
     */
    jQuery(document).on("click", ".btnCategoryRuleEdit", function(e) {
        var typeId = jQuery(this).data("id");
        if (typeId != "") {
            jQuery.ajax({
                url: public_path +"types_category_rules/get/"+typeId,
                type: 'post',
                dataType: 'json',
                data: {
                    "type_id":typeId,
                },
                beforeSend: function() {
                    myShow();
                },
                complete: function() {
                    myHide();
                },
                error: function(respObj) {
                    jQuery('#messsage').find("p").removeClass("callout-danger callout-success");
                    if (respObj.status == 400) {
                        jQuery.each(respObj.responseJSON.errors, function(k, v) {
                            jQuery('.box-body #' + k + '_error').text("");
                            jQuery('.box-body #' + k + '_error').text(v);
                        });
                    }
                },
                success: function(respObj) {
                    jQuery('#messsage').find("p").removeClass("callout-danger callout-success");
                    if (respObj.success) {
                        jQuery(".ruleUpdateId").val(respObj.rules.id);
                        jQuery("#countryId").val(respObj.rules.country_id).trigger("change");
                        jQuery(".clearText").text("");
                        //jQuery("#typeId").val(respObj.rules.type_id).trigger("change");
                        //jQuery("#typeCategoryId").val(respObj.rules.type_category_id).trigger("change");
                        //jQuery("#typesCategoryRulesId").val(respObj.rules.rules_id);
                        //jQuery("typeId").val(respObj.rules.type_id);
                        //jQuery("typesCategoryRulesId").val(respObj.rules.type_category_id);
                        //jQuery(".typeCategoryRulesUpdate").removeClass("hide");
                        //jQuery(".typeCategoryRulesSave").addClass("hide");
                    }
                },
            });
            jQuery(".typeCategorySave,.typeCategoryUpdate,.typeCategoryDelete").addClass("hide");
        }
        return false;
    });

    /**
     * [description]
     * @param  {[type]} ) {               } [description]
     * @return {[type]}   [description]
     */
    jQuery(document).on("click", ".btnTypeCategoryRulesUpdate", function(e) {
        var countryId = jQuery("#countryId").val();
        var typeId = jQuery("#typeId").val();
        var typeCategoryId = jQuery("#typesCategoryId").val();
        var typeCategoryRulesId = jQuery("#typesCategoryRulesId").val();
        var ruleUpdateId = jQuery(".ruleUpdateId").val();
        
        jQuery.ajax({
            url: public_path +"types_category_rules/update/"+ruleUpdateId,
            type: 'post',
            dataType: 'json',
            data: {
                "country_id":countryId,
                "type_id":typeId,
                "type_category_id":typeCategoryId,
                "rules_id":typeCategoryRulesId,
            },
            beforeSend: function() {
                myShow();
            },
            complete: function() {
                myHide();
            },
            error: function(respObj) {
                jQuery('#messsage').find("p").removeClass("callout-danger callout-success");
                if (respObj.status == 400) {
                    jQuery.each(respObj.responseJSON.errors, function(k, v) {
                        jQuery('.box-body #' + k + '_error').text("");
                        jQuery('.box-body #' + k + '_error').text(v);
                    });
                }
            },
            success: function(respObj) {
                jQuery('#messsage').find("p").removeClass("callout-danger callout-success");
                if (respObj.success) {
                    jQuery(".rulesListHtml").html("");
                    jQuery(".typeCategoryRulesUpdate").addClass("hide");
                    jQuery(".categoryRuleHtmlList").html(respObj.html);
                    jQuery("#typesCategoryId").trigger("change");
                    jQuery(".clearText").text("");
                }
            },
        });
        return false;
    });
});
/**
 * [myShow description]
 * @return {[type]} [description]
 */
function myShow() {
    $('#spin').show();
    $('#arrange_spin').show();
    $('#modal_spin').show();
    $('#search_spin').show();
    $('#price_spin').show();
    $('#price_arran_spin').show();
    $('#shipping_arran_spin').show();
    $('#quantity_spin').show();
    $('#shipping_spin').show();
    $('#block_spin').show();
}
/**
 * [myHide description]
 * @return {[type]} [description]
 */
function myHide() {
    $('#spin').hide();
    $('#arrange_spin').hide();
    $('#modal_spin').hide();
    $('#search_spin').hide();
    $('#price_spin').hide();
    $('#price_arran_spin').hide();
    $('#shipping_arran_spin').hide();
    $('#quantity_spin').hide();
    $('#block_spin').hide();
    $('#shipping_spin').hide();
}