(function () {
    const fonts = ["cursive"];
    let captchaValue = "";

    function gencaptcha() {
        let value = btoa(Math.random() * 1000000000);
        value = value.substr(0, 5 + Math.random() * 5);
        captchaValue = value;
    }

    function setcaptcha() {
        let html = captchaValue.split("").map((char) => {
            const rotate = -20 + Math.trunc(Math.random() * 30);
            const fontIndex = Math.trunc(Math.random() * fonts.length);
            return `<span style="
                transform:rotate(${rotate}deg);
                font-family:${fonts[fontIndex]};
            ">${char}</span>`;
        }).join("");
        document.querySelector(".login_form2 #captcha .preview").innerHTML = html;
    }

    function initCaptcha() {
        document.querySelector(".login_form2 #captcha .captcha_refersh").addEventListener("click", function (e) {
            e.preventDefault();
            gencaptcha();
            setcaptcha();
        });

        gencaptcha();
        setcaptcha();
    }
    initCaptcha();

    document.querySelector(".login_form2 .form_button").addEventListener("click", function (e) {
        e.preventDefault();
        let inputcaptchavalue = document.querySelector(".login_form2 #captcha input").value.trim();

        if (inputcaptchavalue === captchaValue) {
            alert("Captcha matched. Form can be submitted.");
            // Here you can submit form using JS or allow natural submit
            e.target.closest("form").submit();
        } else {
            alert("Invalid Captcha");
        }
    });
})();
