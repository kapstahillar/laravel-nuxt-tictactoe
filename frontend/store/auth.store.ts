import { defineStore } from 'pinia';
import type User from '~/api/models/User';

export const useAuthStore = defineStore('auth', {
    state: () => {
        return {
            isAuthenticated: false as boolean,
            user: null as User | null,
        }
    },
    actions: {
        setUser(user: User) {
            this.user = user
            this.isAuthenticated = true
        },
        unsetUser() {
            this.user = null
            this.isAuthenticated = false
        }
    },
    persist: true,

});
