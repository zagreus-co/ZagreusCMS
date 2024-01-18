import EditorJS from '@editorjs/editorjs';
import { useEffect, useRef } from 'react';

// EditorJS Default Plugins
import Header from '@editorjs/header';
import List from "@editorjs/list";
import Checklist from '@editorjs/checklist'
import RawTool from '@editorjs/raw';
import InlineCode from '@editorjs/inline-code';
import CodeTool from '@editorjs/code';

export default function ReactEditorJS({ holder, tools, ...props }) {
    const editorHolder = useRef(holder ?? `zcms-editor-js-${Date.now().toString(16)}`);

    const editor = useRef(null);

    useEffect(() => {
        editor.current = new EditorJS({
            holder: editorHolder.current,
            tools: {
                ...tools,
                header: Header,
                list: {
                    class: List,
                    inlineToolbar: true,
                    config: {
                        defaultStyle: 'unordered'
                    }
                },
                code: CodeTool,
                checklist: {
                    class: Checklist,
                    inlineToolbar: true,
                },
                inlineCode: {
                    class: InlineCode,
                    shortcut: 'CMD+SHIFT+M',
                },
                raw: RawTool,
            },
            ...props
        })
    }, [])

    return (
        <div id={editorHolder.current} />
    )
}