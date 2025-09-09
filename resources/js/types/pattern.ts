import { Block } from "./block";

export interface Pattern {
    id: string;
    name: string;
    icon: string;
    description?: string;
    block: Block;
}
