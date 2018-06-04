 var lk  = (function(document, undefined){
        var idSelectorRE = /^#([\w-]+)$/;
        var tagSelectorRE = /^[\w-]+$/;
        var classSelectorRE = /^\.([\w-]+)$/;
        var $ = function(selector, context){
                context = context || document;
                if (!selector)
                return wrap();
                if (typeof selector === 'string') {
                    try {
                        selector = selector.trim();
                        if (idSelectorRE.test(selector)) {
                            var found = document.getElementById(RegExp.$1);
                            return wrap(found ? [found] : []);
                        }
                        return wrap($.qsa(selector, context), selector);
                    } catch (e) {}
                }
            }
        var wrap = function(dom, selector) {
                        dom = dom || [];
                        Object.setPrototypeOf(dom, $.fn);
                        dom.selector = selector || '';
                        return dom;
                    };

        $.fn = {
                each: function(callback) {
                        [].every.call(this, function(el, idx) {
                            return callback.call(el, idx, el) !== false;
                        });
                        return this;
                    }
             };
        $.qsa = function(selector, context) {
            context = context || document;
           // return $.slice.call(classSelectorRE.test(selector) ? context.getElementsByClassName(RegExp.$1) : tagSelectorRE.test(selector) ? context.getElementsByTagName(selector) : context.querySelectorAll(selector));
            //return context.getElementsByClassName(selector);
            //return context.getElementsByTagName(selector);
            return context.querySelectorAll(selector);
        };
        $.arrs = function(a){
                var arrs = [a[0],a[1]];
                return arrs;
        }

        return $;
    })(document);
    //console.log(lk('.span'));

    (function($,window,document){
        var CLASS_POPUP = 'mui-popup';
        var CLASS_POPUP_BACKDROP = 'mui-popup-backdrop';
        var CLASS_POPUP_IN = 'mui-popup-in';
        var CLASS_POPUP_OUT = 'mui-popup-out';
        var CLASS_POPUP_INNER = 'mui-popup-inner';
        var CLASS_POPUP_TITLE = 'mui-popup-title';
        var CLASS_POPUP_TEXT = 'mui-popup-text';
        var CLASS_POPUP_INPUT = 'mui-popup-input';
        var CLASS_POPUP_BUTTONS = 'mui-popup-buttons';
        var CLASS_POPUP_BUTTON = 'mui-popup-button';
        var CLASS_POPUP_BUTTON_BOLD = 'mui-popup-button-bold';
        var CLASS_POPUP_BACKDROP = 'mui-popup-backdrop';
        var CLASS_ACTIVE = 'mui-active';

        var popupStack = [];
        var backdrop = (function() {
            var element = document.createElement('div');
            element.classList.add(CLASS_POPUP_BACKDROP);
            element.addEventListener($.EVENT_MOVE, $.preventDefault);
            element.addEventListener('webkitTransitionEnd', function() {
                if (!this.classList.contains(CLASS_ACTIVE)) {
                    element.parentNode && element.parentNode.removeChild(element);
                }
            });
            return element;
        }());

    var createInput = function(placeholder,id) {
        return '<div class="' + CLASS_POPUP_INPUT + '"><input type="text" id='+id+' autofocus placeholder="' + (placeholder || '') + '"/></div>';
    };
    var createInner = function(message, title, extra) {
        return '<div class="' + CLASS_POPUP_INNER + '"><div class="' + CLASS_POPUP_TITLE + '">' + title + '</div><div class="' + CLASS_POPUP_TEXT + '">' + message.replace(/\r\n/g, "<br/>").replace(/\n/g, "<br/>") + '</div>' + (extra || '') + '</div>';
    };
    var createButtons = function(btnArray) {
        var length = btnArray.length;
        var btns = [];
        for (var i = 0; i < length; i++) {
            btns.push('<span class="' + CLASS_POPUP_BUTTON + (i === length - 1 ? (' ' + CLASS_POPUP_BUTTON_BOLD) : '') + '">' + btnArray[i] + '</span>');
        }
        return '<div class="' + CLASS_POPUP_BUTTONS + '">' + btns.join('') + '</div>';
    };
        var createPopup = function(html,is_pass, callback) {
            var popupElement = document.createElement('div');
            popupElement.className = CLASS_POPUP;
            popupElement.innerHTML = html;
            var removePopupElement = function() {
                popupElement.parentNode && popupElement.parentNode.removeChild(popupElement);
                popupElement = null;
            };
            popupElement.style.display = 'block';
            document.body.appendChild(popupElement);
            popupElement.offsetHeight;
            popupElement.classList.add(CLASS_POPUP_IN);

            if (!backdrop.classList.contains(CLASS_ACTIVE)) {
                backdrop.style.display = 'block';
                document.body.appendChild(backdrop);
                backdrop.offsetHeight;
                backdrop.classList.add(CLASS_ACTIVE);
            }

            var btns =$.arrs(popupElement.querySelectorAll('.' + CLASS_POPUP_BUTTON));
            //var input = popupElement.querySelector('.' + CLASS_POPUP_INPUT + ' input');
            var tel = popupElement.querySelector('#tel');
            var pass = popupElement.querySelector('#pass');
            var paypass = popupElement.querySelector('#paypass');
            // var type = popupElement.querySelector('#type').valy;
            // console.log(type);
            var popup = {
                element: popupElement,
                close: function(index, animate) {
                    console.log(popupElement);
                    if (popupElement) {
                        if(index == 1){
                            if(tel.value.length <= 0){
                                alert('手机号码不能为空');
                                return false;
                            }
                            if(tel.value.match(/^1[34578]\d{9}$/) == null){
                                alert('手机号码格式错误');
                                return false;
                            }
                            if(is_pass == 1){
                                if(pass.value.length <= 5){
                                    alert('登录密码不能少于6个字符');
                                    return false;
                                }
                                if(paypass.value.length <= 5){
                                    alert('支付密码不能少于6个字符');
                                    return false;
                                }

                            }
                        }

                        var result = callback && callback({
                            index: index || 0,
                            tels: tel && tel.value || '',
                            paw:pass && pass.value || '',
                            paypwd:paypass && paypass.value || '',
                        });
                        if (result === false) { //返回false则不关闭当前popup
                            return;
                        }
                        if (animate !== false) {
                            popupElement.classList.remove(CLASS_POPUP_IN);
                            popupElement.classList.add(CLASS_POPUP_OUT);
                        } else {
                            removePopupElement();
                        }
                        popupStack.pop();
                        //如果还有其他popup，则不remove backdrop
                        if (popupStack.length) {
                            popupStack[popupStack.length - 1]['show'](animate);
                        } else {
                            backdrop.classList.remove(CLASS_ACTIVE);
                        }
                    }
                }
            };
            var handleEvent = function(e) {
                popup.close(btns.indexOf(e.target));
            };
            //$.click('.'+CLASS_POPUP_BUTTON, handleEvent);
            var btt =  document.getElementsByClassName(CLASS_POPUP_BUTTON);
            for (i=0; i<btt.length; i++) {
                var re_obj =  btt[i].addEventListener('click', handleEvent);
            }

            //console.log(document.getElementsByClassName(CLASS_POPUP_BUTTON));
            //document.getElementsByClassName(CLASS_POPUP_BUTTON).addEventListener('click',handleEvent);
            if (popupStack.length) {
                popupStack[popupStack.length - 1]['hide']();
            }
            popupStack.push({
                close: popup.close,
                show: function(animate) {
                    popupElement.style.display = 'block';
                    popupElement.offsetHeight;
                    popupElement.classList.add(CLASS_POPUP_IN);
                },
                hide: function() {
                    popupElement.style.display = 'none';
                    popupElement.classList.remove(CLASS_POPUP_IN);
                }
            });
            return popup;
        };
        //alert(x.a);
        var createPrompt = function(message, placeholder, title, btnArray, callback, type) {
            if (type != 'div') {
                return createPopup(createInner(message, title || '提示', createInput(placeholder.one.title,placeholder.one.id)) +  createButtons(btnArray || ['取消', '确认']),placeholder.is_pass, callback);
            }
        };
        var createPrompt1 = function(message, placeholder, title, btnArray, callback, type) {
            if (type != 'div') {
                return createPopup(createInner(message, title || '提示', createInput(placeholder.one.title,placeholder.one.id) + "<br>" +createInput(placeholder.two.title,placeholder.two.id) + "<br>" +createInput(placeholder.three.title,placeholder.three.id)) +  createButtons(btnArray || ['取消', '确认']),placeholder.is_pass, callback);
            }
        };

    $.prompt = createPrompt;
    $.prompt1 = createPrompt1;
    })(lk,window,document);