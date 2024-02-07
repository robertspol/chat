const deleteAccountBtn = document.querySelector(".panel__btns-wrapper button");
const usersList = document.querySelector(".panel__users-list");
const panelSearch = document.querySelector(".panel__search");

deleteAccountBtn.addEventListener("click", () => {
    const confirmation = confirm("Czy na pewno chcesz usunąć konto?");

    if (confirmation) {
        location.href = "actions/unregister-action.php";
    }
});

let emptyPanelSearch = true;

panelSearch.addEventListener("input", (e) => {
    const searchValue = e.target.value;

    if (searchValue !== "") {
        emptyPanelSearch = false;
    } else {
        emptyPanelSearch = true;
    }

    fetch("actions/search-users-action.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "search_value=" + searchValue,
    })
        .then((res) => {
            if (res.ok) {
                return res.text();
            } else {
                throw new Error("Problem z połączeniem z użytkownikami");
            }
        })
        .then((data) => {
            if (!emptyPanelSearch) {
                usersList.innerHTML = data;
            }
        })
        .catch((err) => console.error(err));
});

setInterval(() => {
    fetch("actions/display-users-action.php")
        .then((res) => {
            if (res.ok) {
                return res.text();
            } else {
                throw new Error("Problem z połączeniem z użytkownikami");
            }
        })
        .then((data) => {
            if (!emptyPanelSearch) {
                return;
            } else {
                usersList.innerHTML = data;
            }
        })
        .catch((err) => console.error(err));
}, 500);
