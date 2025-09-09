import { Block } from "./block";

export interface PageType {
    id: string;
    name: string;
    permalink: string;
    blocks?: Block[];
}
