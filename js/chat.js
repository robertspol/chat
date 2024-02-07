const messages = document.querySelector(".chat-window__messages");
const form = document.querySelector(".chat-window__form");
const messageField = document.querySelector(".chat-window__message-field");
const sendBtn = document.querySelector(".chat-window__send-btn");

form.addEventListener("submit", (e) => {
    e.preventDefault();
});

const formObj = {};

const transformFormIntoObj = () => {
    for (const element of form.elements) {
        if (element.type !== "submit") {
            formObj[element.name] = element.value;
        }
    }
};

const objMessagesID = {};

for (const element of form.elements) {
    if (element.name !== "message" && element.type !== "submit") {
        objMessagesID[element.name] = element.value;
    }
}

const scrollToBottom = () => {
    messages.scrollTop = messages.scrollHeight;
};

let isScrolled = false;

messages.addEventListener("mouseenter", () => {
    isScrolled = true;
});

messages.addEventListener("mouseleave", () => {
    isScrolled = false;
});

sendBtn.addEventListener("click", () => {
    transformFormIntoObj();

    fetch("actions/insert-message-action.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(formObj),
    })
        .then((res) => {
            if (res.ok) {
                messageField.value = "";
                scrollToBottom();
            } else {
                throw new Error("Wystąpił błąd podczas przesyłania danych");
            }
        })
        .catch((err) => {
            console.error(err);
            alert(err);
        });
});

setInterval(() => {
    fetch("actions/get-message-action.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(objMessagesID),
    })
        .then((res) => {
            if (res.ok) {
                return res.text();
            } else {
                throw new Error("Problem z pobraniem wiadomości");
            }
        })
        .then((data) => {
            messages.innerHTML = data;

            if (isScrolled === false) {
                scrollToBottom();
            }
        })
        .catch((err) => {
            console.error(err);
            alert(err);
        });
}, 500);
