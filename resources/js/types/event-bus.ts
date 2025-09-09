import mitt from "mitt";
import { MediaType } from "./media";
import { Block } from "./block";
import { Pattern } from "./pattern";
type MediaSelectedResponse = {
    id: string;
    media: MediaType | MediaType[];
};
type Events = {
    openMediaModal: {
        id: string;
        multiple?: boolean;
        title?: string;
        selectLabel?: string;
        model_type?: string;
        model_id?: number;
        type?: string;
        collection?: string;
    };
    // mediaSelected: MediaType | MediaType[];
    mediaSelected: {
        id: string;
        media: MediaType | MediaType[];
    };
    edit: string | undefined;
    remove: string;
    add: string;
    duplicate: string;
    openAdd: Block | undefined;
    moveUp: string;
    moveDown: string;
    closeEditor: void;
    resetActiveBlock: void;
    expandAll: void;
    collapseAll: void;
    savePattern: Block;
    addPattern: Pattern;
};

const EventBus = mitt<Events>();

export default EventBus;
