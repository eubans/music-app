import type { SongEntity } from '@/entities'

export interface PlaylistEntity {
    id: number,
    title: string,
    songs: SongEntity,
}
