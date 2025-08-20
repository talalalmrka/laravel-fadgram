import mitt from "mitt";
import { MediaType } from "./media";
import { BlockType } from "./block";
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
    editBlock: BlockType;
    deleteBlock: BlockType;
    addBlock: BlockType;
    openAddBlock: BlockType;
    moveUp: BlockType;
    moveDown: BlockType;
};

const eventBus = mitt<Events>();

export default eventBus;
