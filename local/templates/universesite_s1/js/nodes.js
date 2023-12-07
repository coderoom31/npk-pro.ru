window.addEventListener('DOMContentLoaded', () => {
    const swiper = new Swiper('.banner__slider', {
        loop: true,
        autoplay: {
            delay: 5000,
        },
        pagination: {
            el: '.banner__pagination',
        },
    });

    const tabs = () => {
        const tabs = document.querySelectorAll('.products__tabs');

        tabs.forEach(tabsItem => {
            const tabsItems = tabsItem.querySelectorAll('.products__tab');

            tabsItems.forEach(tab => {
               const btn = tab.querySelector('.products__header');
               const btnIcon = btn.querySelector('.products__icon');
               const content = tab.querySelector('.products__content');

                btn.addEventListener('click', (event) => {

                    if (content.classList.contains('show')) {
                        btnIcon.classList.remove('show');
                        content.classList.remove('show');
                    } else {
                        tabsItems.forEach(tab => {
                            tab.querySelector('.products__icon').classList.remove('show');
                            tab.querySelector('.products__content').classList.remove('show');
                        });

                        btnIcon.classList.add('show');
                        content.classList.add('show');
                    }
                });
            });

            tabsItems[0].querySelector('.products__icon').classList.add('show');
            tabsItems[0].querySelector('.products__content').classList.add('show');
        });
    };

    tabs();

    const phoneMask = (selector) => {

        let setCursorPosition = (position, element) => {
            element.focus();

            if (element.setSelectionRange) {
                element.setSelectionRange(position, position);
            } else if (element.createTextRange) {
                let range = element.createTextRange();

                range.collapse(true);
                range.moveEnd('character', position);
                range.moveStart('character', position);
                range.select();
            }
        };

        function createMask (event) {
            let matrix = '+7 (___) ___ __ __',
                i = 0,
                def = matrix.replace(/\D/g, ''),
                val = this.value.replace(/\D/g, '');

            if (def.length >= val.length) {
                val = def;
            }

            this.value = matrix.replace(/./g, a => {
                return /[_\d]/.test(a) && i < val.length ? val.charAt(i++) : i >= val.length ? '' : a;
            });

            if (event.type === 'blur') {
                if (this.value.length == 2) {
                    this.value = '';
                }
            } else {
                setCursorPosition(this.value.length, this);
            }

            if (this.value.charAt(1) != '7') {
                this.value = '';
                this.blur();
            }
        }

        let inputs = document.querySelectorAll(selector);

        inputs.forEach(input => {
            input.addEventListener('input', createMask);
            input.addEventListener('focus', createMask);
            input.addEventListener('blur', createMask);
        });
    };

    phoneMask('[name="phone"]');

    refreshFsLightbox();

    const form = () => {
        const forms = document.querySelectorAll('.form__form');

        forms.forEach(form => {
            let name = form.querySelector('[name="name"]');
            let phone = form.querySelector('[name="phone"]');
            let formStatus = form.querySelector('.form__status')

            form.addEventListener('submit', (event) => {
                event.preventDefault();

                if (name.value.length > 1 && phone.value.length == 18) {
                    $.ajax({
                        url: '/ajax/coderoom_form.php',
                        method: 'POST',
                        data: {
                            name: name.value,
                            phone: phone.value,
                        },
                        success: function () {
                            name.value = '';
                            phone.value = '';

                            formStatus.innerHTML = 'Ваша заявка успешно отправлена.'
                            formStatus.classList.add('green');
                            formStatus.classList.remove('red');
                            formStatus.style.display = 'block';

                            setTimeout(() => {
                                formStatus.style.display = 'none';
                            }, 20000);
                        }
                    });
                } else {
                    formStatus.innerHTML = 'Произошла ошибка. Проверьте правильность заполнения полей.'
                    formStatus.style.display = 'block';
                    formStatus.classList.remove('green');
                    formStatus.classList.add('red');
                }
            });
        });
    };

    form();

    const popup = () => {
        const btns = document.querySelectorAll('.nodes__btn');
        const popup = document.querySelector('.popup');
        const popupClose = document.querySelector('.popup-close');

        btns.forEach(btn => {
           btn.addEventListener('click', () => {
                popup.classList.add('show');
           });
        });

        popupClose.addEventListener('click', () => {
           popup.classList.remove('show');
        });

        popup.addEventListener('click', (event) => {
            if (event.target === popup) {
                popup.classList.remove('show');
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.code === 'Escape' && popup) {
                popup.classList.remove('show');
            }
        });
    };

    popup();
});