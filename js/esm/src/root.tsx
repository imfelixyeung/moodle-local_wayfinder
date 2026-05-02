import * as React from "react";

import {Command as CommandBase} from "cmdk";
import {
    ArrowLeftIcon,
    ChevronRight,
    DotIcon,
    Link2Icon,
    PlayIcon,
    SearchIcon,
} from "lucide-react";
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
    page: Page;
};

type Action = UnknownAction | FormAction | RedirectAction | SubmenuAction;

type Command = {
    type: "command";
    subtype?: undefined;
    name: string;
    description: string | null;
    keywords: string[] | null;
    action: Action | null;
};

type Group = {
    type: "group";
    name: string;
    items: ListItem[];
};

type Page = Omit<Command, "action" | "subtype"> & {
    subtype: "page";
    items: ListItem[];
    action: SubmenuAction | null;
};

type Separator = {
    type: "separator";
};

type ListItem = Command | Group | Page | Separator;

type Props = {
    icon: {html: string};
    strings: RequiredLanguageStrings;
    root: Page;
};

export default function Wayfinder(props: Props) {
    const {strings} = props;
    const [pages, setPages] = React.useState(() => [props.root]);
    const [open, setOpen] = React.useState(false);
    const [value, setValue] = React.useState("");
    const [input, setInput] = React.useState("");
    const openPalette = () => setOpen(true);
    useHotkey("Control+K", openPalette, {enabled: !open});
    useHotkey("/", openPalette, {enabled: !open});

    const resetSearch = () => {
        setValue("");
        setInput("");
    };

    const onCommandSelected = (item: ListItem) => {
        if (item.type !== "command") {
            return;
        }
        const command = item;

        if (item.subtype === "page") {
            setPages((pages) => [...pages, item]);
            resetSearch();
            return;
        }

        const {action} = command;
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
            setPages((pages) => [...pages, action.page]);
            resetSearch();
            return;
        }

        action satisfies never;
    };

    const onDialogOpenChange = (open: boolean) => {
        setOpen(open);
        if (!open) {
            setPages(([page]) => [page]);
            resetSearch();
        }
    };

    const currentPage = React.useMemo(() => pages[pages.length - 1], [pages]);
    const previousPage = React.useMemo(() => pages[pages.length - 2], [pages]);

    const pageBack = () =>
        setPages((pages) => (pages.length === 1 ? pages : pages.slice(0, -1)));

    const onKeyDown: React.KeyboardEventHandler<HTMLDivElement> = (event) => {
        const shouldGoBack =
            previousPage && event.key === "Backspace" && !input;

        if (!shouldGoBack) {
            return;
        }

        event.preventDefault();
        pageBack();
    };

    return (
        <>
            <a
                href="#"
                className="nav-link icon-no-margin"
                onClick={openPalette}
                dangerouslySetInnerHTML={{__html: props.icon.html}}
            />
            <CommandBase.Dialog
                onKeyDown={onKeyDown}
                open={open}
                onOpenChange={onDialogOpenChange}
                label={strings["cmdk:dialog:label"]}
                overlayClassName="wayfinder-overlay"
                contentClassName="wayfinder-content"
                value={value}
                onValueChange={setValue}
            >
                <div wayfind-search="">
                    {previousPage ? (
                        <button wayfinder-back-button="" onClick={pageBack}>
                            <span className="sr-only">
                                {strings["cmdk:back"]}
                            </span>
                            <ArrowLeftIcon
                                wayfinder-back-icon=""
                                aria-hidden={true}
                                size={16}
                            />
                        </button>
                    ) : (
                        <SearchIcon
                            wayfind-search-icon=""
                            aria-hidden={true}
                            size={16}
                        />
                    )}
                    <CommandBase.Input
                        placeholder={strings["cmdk:input:placeholder"]}
                        value={input}
                        onValueChange={setInput}
                        // Annoyingly theme/boost/amd/src/aria.js comboboxFix() messes with cmdk,
                        // this is a hacky way to bypass the element matching,
                        // [role="combobox"][aria-controls]:not([aria-haspopup=dialog])
                        // but means accessibility becomes questionable.
                        aria-haspopup="dialog"
                    />
                </div>
                <CommandBase.List>
                    <CommandBase.Empty>
                        {strings["cmdk:results:empty"]}
                    </CommandBase.Empty>
                    <RenderList
                        items={currentPage.items}
                        onSelect={onCommandSelected}
                    />
                </CommandBase.List>
                <section className="wayfinder-shortcuts-bar-wrapper">
                    <div
                        className="wayfinder-shortcuts-bar"
                        role="list"
                        aria-label={strings["cmdk:shortcuts"]}
                    >
                        <div className="wayfinder-shortcut" role="listitem">
                            <kbd>{strings["cmdk:keys:enter"]}</kbd>{" "}
                            {strings["cmdk:shortcuts:enter:label"]}
                        </div>
                        <div className="wayfinder-shortcut" role="listitem">
                            <kbd>{strings["cmdk:keys:arrowup"]}</kbd>
                            {strings["cmdk:shortcuts:combination:or"]}
                            <kbd>{strings["cmdk:keys:arrowdown"]}</kbd>{" "}
                            {strings["cmdk:shortcuts:updown:label"]}
                        </div>
                        <div className="wayfinder-shortcut" role="listitem">
                            <kbd>{strings["cmdk:keys:escape"]}</kbd>{" "}
                            {strings["cmdk:shortcuts:close:label"]}
                        </div>
                        <div className="wayfinder-shortcut" role="listitem">
                            <kbd>{strings["cmdk:keys:control"]}</kbd>
                            {strings["cmdk:shortcuts:combination:and"]}
                            <kbd>{strings["cmdk:keys:keyk"]}</kbd>{" "}
                            {strings["cmdk:shortcuts:open:label"]}
                        </div>
                    </div>
                </section>
            </CommandBase.Dialog>
        </>
    );
}

const RenderList = ({
    items,
    onSelect,
}: {
    items: ListItem[];
    // eslint-disable-next-line no-unused-vars
    onSelect: (item: ListItem) => void;
}) => {
    return items.map((item, index) => (
        <RenderListItem key={index} item={item} onSelect={onSelect} />
    ));
};

const RenderListItem = ({
    item,
    onSelect,
}: {
    item: ListItem;
    // eslint-disable-next-line no-unused-vars
    onSelect: (item: ListItem) => void;
}) => {
    if (item.type === "command") {
        return (
            <CommandBase.Item
                onSelect={onSelect.bind(null, item)}
                disabled={!item.subtype && !item.action}
                keywords={item.keywords ?? undefined}
            >
                <div className="wayfinder-item">
                    <RenderListItem.Icon item={item} />
                    <div>{item.name}</div>
                </div>
            </CommandBase.Item>
        );
    }

    if (item.type === "group") {
        return (
            <CommandBase.Group heading={item.name}>
                <RenderList items={item.items} onSelect={onSelect} />
            </CommandBase.Group>
        );
    }

    if (item.type === "separator") {
        return <CommandBase.Separator />;
    }

    item satisfies never;
    return null;
};

RenderListItem.Icon = ({item}: {item: ListItem}) => {
    const Icon = React.useMemo(() => {
        if (item.type !== "command") {
            return DotIcon;
        }

        if (item.subtype === "page") {
            return ChevronRight;
        }

        if (!item.action) {
            return DotIcon;
        }

        if (item.action.id === "submenu") {
            return ChevronRight;
        }

        if (item.action.id === "redirect") {
            return Link2Icon;
        }

        if (item.action.id === "form") {
            return PlayIcon;
        }
        item.action.id satisfies "unknown";
        return null;
    }, [item]);

    if (!Icon) {
        return null;
    }

    return <Icon size={16} aria-hidden={true} />;
};
