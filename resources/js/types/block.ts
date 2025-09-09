export interface Block {
    id: string;
    type: string;
    icon?: string;
    label?: string;
    children?: Block[];
    inner?: string | string[];
    features?: string[];
    attributes: Record<string, any>;
    [key: string]: any;
}
