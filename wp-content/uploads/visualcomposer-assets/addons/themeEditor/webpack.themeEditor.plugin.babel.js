import { ConcatSource } from 'webpack-sources'

export default class AddonsPlugin {
  constructor (tag) {
    this.tag = tag
  }

  apply (compiler) {
    compiler.hooks.compilation.tap(
      'AddonsPlugin',
      compilation => {
        const handler = modules => {
          modules.map((module) => {
            if (module.id) {
              // Replace ../../node_modules
              module.id = module.id.replace('../../node_modules', './node_modules')
            }
            return module
          })
        }
        compilation.hooks.moduleIds.tap(
          'AddonsPlugin',
          handler
        )

        // Intercept default chunk template plugin
        compilation.chunkTemplate.hooks.render.intercept(
          {
            'register': (options) => {
              if (options.name === 'JsonpChunkTemplatePlugin') {
                options.fn = (modules, chunk) => {
                  const jsonpFunction = compilation.chunkTemplate.outputOptions.jsonpFunction
                  const globalObject = compilation.chunkTemplate.outputOptions.globalObject
                  const source = new ConcatSource()
                  source.add(
                    `(${globalObject}[${JSON.stringify(
                      jsonpFunction
                    )}] = ${globalObject}[${JSON.stringify(
                      jsonpFunction
                    )}] || []).push([${JSON.stringify(chunk.ids)},`
                  )
                  source.add(modules)
                  const entries = [ chunk.entryModule ].filter(Boolean).map(m =>
                    [ m.id ].concat(
                      Array.from(chunk.groupsIterable)[ 0 ]
                        .chunks.filter(c => c !== chunk)
                        .map(c => c.id)
                    )
                  )
                  if (entries.length > 0) {
                    source.add(`,${JSON.stringify(entries)}`)
                  }
                  // Add manual element entry point
                  if (chunk.name === 'themeEditor') {
                    source.add(`,[['./${this.tag}/src/themeEditor.js']]])`)
                  } else if (chunk.name === 'layoutsView') {
                    source.add(`,[['./${this.tag}/src/layoutsView.js']]])`)
                  } else {
                    source.add(`])`)
                  }

                  return source
                }
              }
              return options
            }
          }
        )
      }
    )
  }
}
