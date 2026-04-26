import * as React from "react";

import {Command} from "cmdk";
import {useHotkey} from "@tanstack/react-hotkeys";
import {type RequiredLanguageStrings} from "./strings";

type Item = {
    name: string;
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
                        <Command.Item key={index}>{item.name}</Command.Item>
                    ))}
                </Command.List>
            </Command.Dialog>
        </>
    );
}
