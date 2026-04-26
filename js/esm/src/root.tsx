import * as React from "react";

import {Command} from "cmdk";
import {useHotkey} from "@tanstack/react-hotkeys";
import {type RequiredLanguageStrings} from "./strings";

type BaseAction = {
    type: "action";
};

type UnknownAction = BaseAction & {
    id: "unknown";
};

type FormAction = BaseAction & {
    id: "form";
    url: string;
    data: Record<string, string>;
};

type RedirectAction = BaseAction & {
    id: "redirect";
    url: string;
};

type SubmenuAction = BaseAction & {
    id: "submenu";
    items: ListItem[];
};

type Action = UnknownAction | FormAction | RedirectAction | SubmenuAction;

type Item = {
    type: "item";
    name: string;
    description: string | null;
    action: Action | null;
};

type Separator = {
    type: "separator";
};

type ListItem = Item | Separator;

type Props = {
    icon: {html: string};
    strings: RequiredLanguageStrings;
    list: ListItem[];
};

export default function Wayfinder(props: Props) {
    const [items, setItems] = React.useState(() => props.list);
    const [open, setOpen] = React.useState(false);
    const [input, setInput] = React.useState("");
    const openPalette = () => setOpen(true);
    useHotkey("Control+K", openPalette);
    useHotkey("/", openPalette);

    const onItemSelected = (item: Item) => {
        const {action} = item;
        if (!action) {
            return;
        }

        if (action.id === "unknown") {
            return;
        }

        if (action.id === "form") {
            const form = document.createElement("form");
            form.action = action.url;
            form.method = "post";
            form.style.display = "none";
            for (const [key, value] of Object.entries(action.data)) {
                const input = document.createElement("input");
                input.name = key;
                input.value = value;
                form.appendChild(input);
            }
            document.body.appendChild(form);
            form.submit();
            form.remove();
            return;
        }

        if (action.id === "redirect") {
            window.location.assign(action.url);
            return;
        }

        if (action.id === "submenu") {
            setItems(action.items);
            setInput("");
            return;
        }

        action satisfies never;
    };

    const onDialogOpenChange = (open: boolean) => {
        setOpen(open);
        if (!open) {
            setItems(props.list);
            setInput("");
        }
    };

    return (
        <>
            <a
                href="#"
                className="nav-link icon-no-margin"
                onClick={openPalette}
                dangerouslySetInnerHTML={{__html: props.icon.html}}
            />
            <Command.Dialog
                open={open}
                onOpenChange={onDialogOpenChange}
                label={props.strings["cmdk:dialog:label"]}
                overlayClassName="wayfinder-overlay"
                contentClassName="wayfinder-content"
            >
                <Command.Input
                    placeholder={props.strings["cmdk:input:placeholder"]}
                    value={input}
                    onValueChange={setInput}
                    // Annoyingly theme/boost/amd/src/aria.js comboboxFix() messes with cmdk,
                    // this is a hacky way to bypass the element matching,
                    // [role="combobox"][aria-controls]:not([aria-haspopup=dialog])
                    // but means accessibility becomes questionable.
                    aria-haspopup="dialog"
                />
                <Command.List>
                    <Command.Empty>
                        {props.strings["cmdk:results:empty"]}
                    </Command.Empty>

                    {items.map((item, index) => {
                        if (item.type === "separator") {
                            return <Command.Separator key={index} />;
                        }
                        return (
                            <Command.Item
                                key={index}
                                onSelect={onItemSelected.bind(null, item)}
                                disabled={!item.action}
                            >
                                {item.name}
                            </Command.Item>
                        );
                    })}
                </Command.List>
            </Command.Dialog>
        </>
    );
}
