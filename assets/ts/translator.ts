import Translator from 'bazinga-translator';

export const getTranslator = async () => {
    try {
        const res = await fetch((window as any).jsonTranslationsUrl);
        if (res.ok && res.headers.get('content-type')?.includes('application/json')) {
            Translator.fromJSON(await res.json());
        } else {
            console.warn('Translations endpoint returned non-JSON response, falling back to keys');
        }
    } catch (e) {
        console.warn('Failed to load translations, falling back to keys', e);
    }
    return Translator;
}
