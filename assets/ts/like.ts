export const getUserFavorites = async () => {
    if (!(window as any).isAuthenticated) {
        return null;
    }

    const likeButtons = document.querySelectorAll('[data-like]');
    const likeData = {};
    likeButtons.forEach((button) => {
        const id = button.getAttribute('data-like-id');
        const type = button.getAttribute('data-like-type');
        if (!likeData[type]) {
            likeData[type] = [];
        }
        likeData[type].push(id);
    })

    const response = await fetch('/api/user/favorite', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(likeData)
    })

    return await response.json()
}
