import {defineStore} from "pinia";

export type RootState = {
    userFavorite: any;
};

export const useMainStore = defineStore({
    id: "mainStore",
    state: () => ({
        userFavorite: {},
    } as RootState),

    getters: {
        getUserFavorite() {
            return this.userFavorite;
        },
        isUserFavorite: (state) => (type: string, id: number) => {
            return state.userFavorite[type] && state.userFavorite[type].includes(id);
        }
    },

    actions: {
        setUserFavorite(data: any) {
            this.userFavorite = data;
        },
        async toggleUserFavorite(type: string, id: string) {
            if (!this.userFavorite[type]) {
                this.userFavorite[type] = [];
            }

            const index = this.userFavorite[type].indexOf(id);
            if (index === -1) {
                this.userFavorite[type].push(id);
                await fetch('/api/user/favorite/create', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        type,
                        id
                    })
                })
            } else {
                this.userFavorite[type].splice(index, 1);
                await fetch('/api/user/favorite/delete', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        type,
                        id
                    })
                })
            }
        }
    },
});
