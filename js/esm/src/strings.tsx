export const requiredLanguageStrings = [
    "cmdk:dialog:label",
    "cmdk:input:placeholder",
    "cmdk:results:empty",
] as const;
export type RequiredLanguageString = (typeof requiredLanguageStrings)[number];
export type RequiredLanguageStrings = Record<RequiredLanguageString, string>;
