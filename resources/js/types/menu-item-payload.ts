// types/menu-item-payload.ts
import { MenuItemType } from './menu-item'

export interface MenuItemPayload extends Omit<MenuItemType, 'children' | 'id'> {
    id?: string
    children?: MenuItemPayload[]
}