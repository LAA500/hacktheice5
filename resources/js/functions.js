export function notify(
    message,
    type = "default",
    duration = 3000,
    options = {}
) {
    app.$toastify(message, { type: type });
}

export function currency(sum = 0, digitsAfterAmount = 0) {
    return Number(sum).toLocaleString("ru-RU", {
        style: "currency",
        currency: "RUB",
        minimumFractionDigits: digitsAfterAmount,
    });
}

export function link(type, link, params = {}) {
    switch (type) {
        case "link":
            return route(link, params);
        case "click":
            return (window.location.href = route(link, params));
        case "redirect":
            return (window.location.href = route(link, params));
    }
}

export function lang(langKey, replace = {}) {
    let line = App.lang[langKey];

    for (let key in replace) {
        line = line.replace(`:${key}`, replace[key]);
    }

    return line ? line : langKey;
}

export function keypressAction(actions) {
    $(document).keypressAction({ actions });
}

export function applyDrag(arr, dragResult) {
    const { removedIndex, addedIndex, payload } = dragResult;
    if (removedIndex === null && addedIndex === null) return arr;

    const result = [...arr];
    let itemToAdd = payload;

    if (removedIndex !== null) {
        itemToAdd = result.splice(removedIndex, 1)[0];
    }

    if (addedIndex !== null) {
        result.splice(addedIndex, 0, itemToAdd);
    }

    return result;
}

export function screenWidth() {
    return screen.width;
}
