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

type Action = UnknownAction | RedirectAction;

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

        action satisfies never;
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
                onOpenChange={setOpen}
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

                    {props.list.map((item, index) => (
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
