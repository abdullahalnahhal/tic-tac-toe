FormControl = function(element, messages = [], lang = 'en')
{
    this.element = element;
    this.lang = lang;
    if (messages) {
        this.messages = messages;
    }
    this.form_inputs = {
        select:{
            default_error:['', null]
        },
        input:{
            text:{
                default_error:['', null]
            },
            file:{
                default_error:['', null],
                extra_error:['accept'],
            },
            radio:{
                default_error:['', null] 
            },
            checkbox:{
                default_error:['', null] 
            },

	    }, 
        textarea:{
            default_error:['', null]
        }
    }
    this.messages = {
        valueMissing :{
            en:"Please fill this field, cann't be empty",
            ar:"بالرجاء ملئ هذا الحقل ، لا يمكن تركه فارغاً"
        },
        tooShort:{
            en:"Please increase these {characters}, these value is too short",
            ar:"من فضلك أزد هذه ال{} ، هذه القيمة قصيرة جداً"
        },
        tooLong:{
            en:"Please dencrease these {characters}, these value is too long",
            ar:"من فضلك قلل هذه ال{characters} ، هذه القيمة كبيرة جداً"
        },
        rangeOverflow:{
            en:"Please Decrease the value, these number is too heigh",
            ar:"من فضلك انقص هذا الرقم، هذا الرقم كبير جدا"
        },
        rangeUnderflow:{
            en:"Please increase the value, these number is too low",
            ar:"من فضلك أزد هذا الرقم، هذا الرقم صغير جدا"
        },
        maxSize:{
            en:"Thse file is too big, Files can't be bigger than {size}",
            ar:"هذا الملف كبير جداً، لا يمكن أن يكون الملف أكبر من {size}"
        },
        stepMismatch:{
            en:"These value can't be like this, value can take just {step} on increase and decrease",
            ar:"هذه القيمة لا يمكن أن تكون بهذه الصورة ، القيمة يجب أن تأخذ {step} في الزيادة و النقصان"
        },
    }
	this.validation = function()
	{
		validate = true;
        for (prop in this.form_inputs) {
            var is_valid = true;
            inputs = $(element).find(prop);
            inputs.each(function(index, el) {
                if ($(this).attr('type') == "file") {
                    if (this.files[0].size > $(this).attr('maxsize')) {
                        this.setCustomValidity( formcontrol.messages.maxSize[formcontrol.lang].replace("{size}", $(this).attr('maxsize')+" byte "));
                        this.reportValidity();
                        $(this).on('change', function(event) {
                           this.setCustomValidity("");
                        });
                    }
                    is_valid = false;
                    return false;
                }else{
                    is_valid = $(this)[0].checkValidity();
                    if (!is_valid) {
                        formcontrol.showError($(this));
                        return false;
                    }  
                }
            });
            if (!is_valid){
                break;
            }
        }  
	}
    this.showError = function(element) 
    {
        validity = element[0].validity;
        for (prop in validity) {
            if (this.messages.hasOwnProperty(prop) && validity[prop]) {
                element[0].setCustomValidity(formcontrol.messages[prop][this.lang]);
                break;
            }else{
                if (validity[prop]) {
                    msg = element.attr(prop);
                    try{
                        msg = JSON.parse(element.attr(prop))[this.lang];
                    }catch(e){}
                    element[0].setCustomValidity(msg);
                    break;
                }
            }
            element[0].reportValidity();
            element.keydown(function(event) {
               element[0].setCustomValidity("");
            });
        }
        
    }
}
formcontrol = new FormControl('#login');
$("#submit").click(function(event) {
    formcontrol.validation();
});
