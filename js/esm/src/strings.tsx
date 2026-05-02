export const requiredLanguageStrings = [
    "cmdk:back",
    "cmdk:dialog:label",
    "cmdk:input:placeholder",
    "cmdk:keys:arrowdown",
    "cmdk:keys:arrowup",
    "cmdk:keys:control",
    "cmdk:keys:enter",
    "cmdk:keys:escape",
    "cmdk:keys:keyk",
    "cmdk:results:empty",
    "cmdk:shortcuts",
    "cmdk:shortcuts:close:label",
    "cmdk:shortcuts:combination:and",
    "cmdk:shortcuts:combination:or",
    "cmdk:shortcuts:enter:label",
    "cmdk:shortcuts:open:label",
    "cmdk:shortcuts:updown:label",
] as const;
export type RequiredLanguageString = (typeof requiredLanguageStrings)[number];
export type RequiredLanguageStrings = Record<RequiredLanguageString, string>;
