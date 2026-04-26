import * as React from "react";

import {Command} from "cmdk";
import {useHotkey} from "@tanstack/react-hotkeys";
import {type RequiredLanguageStrings} from "./strings";

type UnknownAction = {
    id: "unknown";
};

type RedirectAction = {
    id: "redirect";
    url: string;
};

type SubmenuAction = {
    id: "submenu";
    items: Item[];
};

type Action = UnknownAction | RedirectAction | SubmenuAction;

type Item = {
    name: string;
    description: string | null;
    action: Action | null;
};

type Props = {
    icon: {html: string};
    strings: RequiredLanguageStrings;
    list: Item[];
};

export default function Wayfinder(props: Props) {
    const [items, setItems] = React.useState(() => props.list);
    const [open, setOpen] = React.useState(false);
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

        if (action.id === "redirect") {
            window.location.assign(action.url);
            return;
        }

        if (action.id === "submenu") {
            setItems(action.items);
            return;
        }

        action satisfies never;
    };

    const onDialogOpenChange = (open: boolean) => {
        setOpen(open);
        if (!open) {
            setItems(props.list);
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
                    className="form-control"
                    placeholder={props.strings["cmdk:input:placeholder"]}
                />
                <Command.List>
                    <Command.Empty>
                        {props.strings["cmdk:results:empty"]}
                    </Command.Empty>

                    {items.map((item, index) => (
                        <Command.Item
                            key={index}
                            onSelect={onItemSelected.bind(null, item)}
                            disabled={!item.action}
                        >
                            {item.name}
                        </Command.Item>
                    ))}
                </Command.List>
            </Command.Dialog>
        </>
    );
}
