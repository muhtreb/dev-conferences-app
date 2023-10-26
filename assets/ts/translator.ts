import Translator from 'bazinga-translator';

export const getTranslator = async () => {
    // fetch translations from json url (window.jsonTranslationsUrl) get it from url and transform it to json
    const res = await fetch((window as any).jsonTranslationsUrl)
    const json = await res.json()

    // set translations
    Translator.fromJSON(json);
    return Translator;
}
