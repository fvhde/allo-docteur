import { writable } from 'svelte/store';
import { browser } from "$app/environment";

export const me = writable(browser && localStorage.getItem('me'));
export const token = writable(browser && localStorage.getItem('token'));

me.subscribe(value => {
    if (value) {
        if (browser) return localStorage.setItem('me', value);
    } else {
        if (browser) return localStorage.removeItem('me');
    }
});

token.subscribe(value => {
    if (value) {
        if (browser) return localStorage.setItem('token', value);
    } else {
        if (browser) return localStorage.removeItem('token');
    }
});