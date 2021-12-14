function updateOptions(options) {
    if (localStorage.getItem("Auth")) {
        options.headers = {
            ...options.headers,
            "Authorization": `Bearer ${JSON.parse(localStorage.getItem("Auth")).token}`
        }
    }
    const update = { ...options };
    update.headers = {
        ...update.headers,
        "Content-Type": 'application/json',
        "Accept": 'application/json',
    };
    return update;
}

export default {
    get: async function (url, options) {
        try {
            if (!options) options = {};
            options.method = "GET";
            const response = await fetch(process.env.VUE_APP_API_BASE_URL + url, updateOptions(options));
            return response.json();
        } catch (err) {
            console.log(err)
        }
    },
    post: async function (url, options) {
        try {
            if (!options) options = {};
            options.method = "POST";
            const response = await fetch(process.env.VUE_APP_API_BASE_URL + url, updateOptions(options));
            return response.json();
        } catch (err) {
            console.log(err)
        }
    }
}